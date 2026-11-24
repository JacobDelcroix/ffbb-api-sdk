"""Extraction statique des modèles Python de ffbb-data-client (aucun code n'est exécuté).

Usage : python3 tools/extract_models.py <chemin du clone ffbb-data-client> <fichier de sortie JSON>

Lit chaque classe qui possède un `from_dict`, et pour chaque champ relève la clé JSON
et le convertisseur utilisé (`from_str(obj, "nomClubPro")`, `from_obj(Commune.from_dict, obj, "commune")`…).
Seules les classes atteignables depuis les racines (hits Meilisearch, Live) sont gardées.
Le résultat alimente bin/generate-dtos, qui produit src/Data/Search/*.
"""
import ast
import json
import sys
from pathlib import Path

ROOTS = [
    'OrganismesHit', 'RencontresHit', 'TerrainsHit', 'SallesHit', 'TournoisHit',
    'PratiquesHit', 'EngagementsHit', 'FormationsHit', 'CompetitionsHit', 'Live',
]

SCALARS = {
    'from_str': 'string', 'from_phone': 'string', 'from_uuid': 'string', 'from_time': 'string',
    'from_int': 'int', 'from_float': 'float', 'from_bool': 'bool',
    'from_datetime': 'datetime', 'from_timestamp': 'datetime',
    'from_duration': 'raw', 'from_enum': 'string',
}


def literal_key(args):
    for arg in reversed(args):
        if isinstance(arg, ast.Constant) and isinstance(arg.value, str):
            return arg.value
    return None


def from_dict_target(node):
    """`Commune.from_dict` -> 'Commune'."""
    if isinstance(node, ast.Attribute) and node.attr == 'from_dict' and isinstance(node.value, ast.Name):
        return node.value.id
    return None


def get_key(call):
    """`obj.get("clock")` -> 'clock'."""
    if isinstance(call, ast.Call) and isinstance(call.func, ast.Attribute) and call.func.attr == 'get' and call.args:
        first = call.args[0]
        if isinstance(first, ast.Constant) and isinstance(first.value, str):
            return first.value
    return None


def analyse_value(value, variables):
    if isinstance(value, ast.IfExp):
        return analyse_value(value.body, variables)

    if not isinstance(value, ast.Call):
        if isinstance(value, ast.Name) and value.id in variables:
            return dict(variables[value.id])
        return None

    key = get_key(value)
    if key is not None:
        return {'kind': 'raw', 'key': key}

    func = value.func
    name = func.id if isinstance(func, ast.Name) else None

    if name in SCALARS:
        return {'kind': SCALARS[name], 'key': literal_key(value.args)}

    if name == 'from_obj' and value.args:
        return {'kind': 'object', 'class': from_dict_target(value.args[0]), 'key': literal_key(value.args)}

    if name == 'from_list' and value.args:
        item = value.args[0]
        target = from_dict_target(item)
        if target:
            return {'kind': 'list', 'class': target, 'key': literal_key(value.args)}
        scalar = {'str': 'string', 'int': 'int', 'float': 'float', 'bool': 'bool'}.get(getattr(item, 'id', None))
        return {'kind': 'list', 'of': scalar or 'raw', 'key': literal_key(value.args)}

    if name == 'from_officiels_list' and value.args:
        return {'kind': 'list', 'of': 'raw', 'key': get_key(value.args[0]) or 'officiels'}

    # Valeur dérivée d'une variable déjà lue (ex. Clock.from_str(clock_val)) : on garde la donnée brute.
    for arg in value.args:
        if isinstance(arg, ast.Name) and arg.id in variables:
            return {'kind': 'raw', 'key': variables[arg.id]['key']}

    return None


def extract_class(cls):
    from_dict = next((n for n in cls.body if isinstance(n, ast.FunctionDef) and n.name == 'from_dict'), None)
    if from_dict is None:
        return None

    variables = {}
    constructor = None

    for node in ast.walk(from_dict):
        if isinstance(node, ast.Assign) and len(node.targets) == 1 and isinstance(node.targets[0], ast.Name):
            info = analyse_value(node.value, variables)
            if info and info.get('key'):
                variables[node.targets[0].id] = info
        if isinstance(node, ast.Return) and isinstance(node.value, ast.Call):
            func = node.value.func
            if isinstance(func, ast.Name) and func.id == cls.name:
                constructor = node.value

    if constructor is None:
        return None

    fields = []
    for keyword in constructor.keywords:
        value = keyword.value
        info = variables.get(value.id) if isinstance(value, ast.Name) else analyse_value(value, variables)
        if info and info.get('key'):
            fields.append({'attr': keyword.arg, **info})

    doc = ast.get_docstring(cls) or ''
    return {'doc': doc.split('\n')[0], 'fields': fields}


def main():
    upstream = Path(sys.argv[1])
    output = Path(sys.argv[2])
    models = {}

    for path in sorted((upstream / 'src' / 'ffbb_data_client' / 'models').glob('*.py')):
        tree = ast.parse(path.read_text())
        for cls in (n for n in tree.body if isinstance(n, ast.ClassDef)):
            data = extract_class(cls)
            if data is not None:
                models[cls.name] = {'file': path.name, **data}

    reachable, queue = {}, list(ROOTS)
    while queue:
        name = queue.pop()
        if name in reachable or name not in models:
            continue
        reachable[name] = models[name]
        queue.extend(f['class'] for f in models[name]['fields'] if f.get('class'))

    missing = sorted({f['class'] for m in reachable.values() for f in m['fields'] if f.get('class') and f['class'] not in models})
    output.write_text(json.dumps(dict(sorted(reachable.items())), indent=1, ensure_ascii=False) + '\n')
    print(f'{len(reachable)} modèles extraits' + (f' ; classes introuvables : {missing}' if missing else ''))


if __name__ == '__main__':
    main()
