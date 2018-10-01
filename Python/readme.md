# Python 3


## Structuring Imports


- `parent.one`
	- `parent/__init__.py`
	- `parent/one/__init__.py`

```python
parent/
    __init__.py
    one/
        __init__.py
    two/
        __init__.py
    three/
        __init__.py
```





```python
if __name__ == '__main__':
    invoke_the_real_code()
```
- `__name__` global variable that holds the name of **current** Python module
- `__main__` Python module name when invoked from CLI



**Module**
- file containing Python code
- when imported: is executed

**Package**
- **namespace** for collection of modules
- minimum unit of distribution
- don't import package, import a module from a package
- `__init__.py` make directory a package. Gets executed upon import

```python
pizzapy/
├── __init__.py
├── menu.py
└── pizza.py
```

Example: import everything from modules
```python
# pizzapy/__init__.py
from pizzapy.pizza import *
from pizzapy.menu import *
```

#### Absolute and relative imports

