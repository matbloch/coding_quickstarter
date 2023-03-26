# Pathlib









**Operations**

- `Path(str).stem` the filename, **without** extension
  - `a/b/c/deef.png` > `deef`
- `Path(str).name` the filename, **with** extension
  - `a/b/c/deef.png` > `deef.png`
- `Path(str).parent` the containing folder name
  - `a/b/c/deef.png` > `a/b/c`
- `str(Path(str))` the initial string representation of the path



**Path concatenation**