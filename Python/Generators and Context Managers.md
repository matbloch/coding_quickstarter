# Generators and Context Managers





## Generators

> An expression that returns an iterator and can e.g. be consumed in a `for` loop

- using `yield`

```python
import random
def lottery():
    for i in range(6):
        yield random.randint(1, 40)
for random_number in lottery():
       print("And the next number is... %d!" %(random_number))
```



## 





## Context Manager

- allow to control allocation and release of resources
- `with` is most common usecase



**Context Manager as a Class**

- `__enter__` returned by `with()` statement 
- `__exit__` cleanup/release method

```python
class File(object):
    def __init__(self, file_name, method):
        self.file_obj = open(file_name, method)
    def __enter__(self):
        return self.file_obj
    def __exit__(self, type, value, traceback):
        self.file_obj.close()
```

Usage:

```python
with File(path) as f:
    f.wite('hola')
```

**Context Manager as a Generator**

```python
from contextlib import contextmanager

@contextmanager
def open_file(name):
    f = open(name, 'w')
    try:
        yield f
    finally:
        f.close()
```

Usage:

```python
with open_file('some_file') as f:
    f.write('hola!')
```

