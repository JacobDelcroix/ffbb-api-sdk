"""Lit statiquement (sans les exécuter) les classes *Fields du SDK Python via ast."""
import ast, json, sys
from pathlib import Path

def load(path):
    tree = ast.parse(Path(path).read_text())
    cls = next(n for n in tree.body if isinstance(n, ast.ClassDef))
    consts, methods = {}, {}
    for node in cls.body:
        if isinstance(node, ast.Assign) and isinstance(node.targets[0], ast.Name):
            v = node.value
            if isinstance(v, ast.Constant) and isinstance(v.value, str):
                consts[node.targets[0].id] = v.value
        if isinstance(node, ast.FunctionDef):
            ret = next((n for n in ast.walk(node) if isinstance(n, ast.Return)), None)
            methods[node.name] = ret.value if ret else None
    def ev(e):
        if isinstance(e, ast.List):
            return [x for el in e.elts for x in ev(el)]
        if isinstance(e, ast.Attribute) and isinstance(e.value, ast.Name) and e.value.id == 'cls':
            return [consts[e.attr]]
        if isinstance(e, ast.Constant):
            return [e.value]
        if isinstance(e, ast.BinOp) and isinstance(e.op, ast.Add):
            return ev(e.left) + ev(e.right)
        if isinstance(e, ast.Call) and isinstance(e.func, ast.Attribute):
            return ev(methods[e.func.attr])
        if isinstance(e, ast.Starred):
            return ev(e.value)
        raise ValueError(ast.dump(e))
    return {m: ev(v) for m, v in methods.items() if v is not None}

if __name__ == '__main__':
    base = Path(sys.argv[1])
    out = {}
    for name in ['organisme', 'competition', 'poule', 'saison']:
        for m, v in load(base / f'{name}_fields.py').items():
            out[f'{name}.{m}'] = v
    print(json.dumps(out, indent=1))
