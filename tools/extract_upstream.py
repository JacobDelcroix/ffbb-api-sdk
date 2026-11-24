"""Extraction statique du SDK Python ffbb-data-client (aucun code du repo n'est exécuté).

Usage : python3 tools/extract_upstream.py <chemin du clone ffbb-data-client> <dossier de sortie>

Produit :
  - config.json  : constantes de ffbb_data_client/config.py (littéraux, os.getenv(..., défaut) résolus)
  - methods.json : méthodes publiques synchrones de FFBBDataClient (façades REST + recherche)
  - fields.json  : listes de champs Directus des classes *Fields
"""
import ast
import json
import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).parent))
from extract_fields import load as load_fields  # noqa: E402


def extract_config(path: Path) -> dict:
    tree = ast.parse(path.read_text())
    values: dict = {}

    def resolve(node):
        if isinstance(node, ast.Constant):
            return node.value
        if isinstance(node, ast.Name) and node.id in values:
            return values[node.id]
        if isinstance(node, (ast.List, ast.Tuple)):
            return [resolve(e) for e in node.elts]
        if isinstance(node, ast.BinOp) and isinstance(node.op, ast.Add):
            left, right = resolve(node.left), resolve(node.right)
            if isinstance(left, str) and isinstance(right, str):
                return left + right
        if isinstance(node, ast.Call):
            func = node.func
            # os.getenv("X", "défaut") -> "défaut"
            if isinstance(func, ast.Attribute) and func.attr == 'getenv' and len(node.args) >= 2:
                return resolve(node.args[1])
            # os.getenv(...).rstrip("/") + "/" et appels de méthode str simples
            if isinstance(func, ast.Attribute) and func.attr in ('rstrip', 'strip', 'lower'):
                base = resolve(func.value)
                if isinstance(base, str):
                    args = [resolve(a) for a in node.args]
                    return getattr(base, func.attr)(*args)
            # list(dict.fromkeys([...])) -> liste dédupliquée
            if isinstance(func, ast.Name) and func.id == 'list' and node.args:
                inner = node.args[0]
                if isinstance(inner, ast.Call) and isinstance(inner.func, ast.Attribute) and inner.func.attr == 'fromkeys':
                    items = resolve(inner.args[0])
                    if isinstance(items, list):
                        return list(dict.fromkeys(items))
        if isinstance(node, ast.Dict):
            return {resolve(k): resolve(v) for k, v in zip(node.keys, node.values)}
        raise ValueError('non résolu')

    for stmt in tree.body:
        target = None
        if isinstance(stmt, ast.Assign) and len(stmt.targets) == 1 and isinstance(stmt.targets[0], ast.Name):
            target, value = stmt.targets[0].id, stmt.value
        elif isinstance(stmt, ast.AnnAssign) and isinstance(stmt.target, ast.Name) and stmt.value is not None:
            target, value = stmt.target.id, stmt.value
        if target and target.isupper():
            try:
                values[target] = resolve(value)
            except ValueError:
                pass
    return dict(sorted(values.items()))


def extract_methods(clients_dir: Path) -> list:
    names = set()
    for file in ('ffbb_data_client.py', '_rest_facade.py', '_search_facade.py'):
        tree = ast.parse((clients_dir / file).read_text())
        for cls in (n for n in tree.body if isinstance(n, ast.ClassDef)):
            for node in cls.body:
                if isinstance(node, (ast.FunctionDef, ast.AsyncFunctionDef)):
                    name = node.name
                    if name.startswith('_') or name.endswith('_async') or name in ('create', 'aclose'):
                        continue
                    names.add(name)
    return sorted(names)


def main() -> None:
    upstream = Path(sys.argv[1])
    out = Path(sys.argv[2])
    out.mkdir(parents=True, exist_ok=True)
    pkg = upstream / 'src' / 'ffbb_data_client'

    fields = {}
    for name in ('organisme', 'competition', 'poule', 'saison'):
        for method, value in load_fields(pkg / 'models' / f'{name}_fields.py').items():
            fields[f'{name}.{method}'] = value

    files = {
        'config.json': extract_config(pkg / 'config.py'),
        'methods.json': extract_methods(pkg / 'clients'),
        'fields.json': fields,
    }
    for filename, data in files.items():
        (out / filename).write_text(json.dumps(data, indent=1, ensure_ascii=False, sort_keys=True) + '\n')
        print(f'{filename}: {len(data)} entrées')


if __name__ == '__main__':
    main()
