# Python 3



### PEP 8 and Naming





### Project Structure and Imports







`from .game_round_settings import GameRoundSettings`









### Control Structures

**for in range**

```python
# Prints out the numbers 0,1,2,3,4
for x in range(5):
    print(x)
# Prints out 3,4,5
for x in range(3, 6):
    print(x)
# Prints out 3,5,7
for x in range(3, 8, 2):
    print(x)
```

**for item in dict**

```python
for key, item in my_dict.items():
    print(item)
```

### Type Declarations

- variables: `variable_name: type`
- methods: ``def function_name(parameter1: type) -> return_type:``
- import types in your program: `from typing import *`
- use type aliases: `VectorType = List[Tuple[float, float]] `

**Example**

```python
from typing import Dict, Tuple
# Tuples let you declare each type separately
my_data: Tuple[str, int, float] = ("Adam", 10, 5.7)
fallback_name: Dict[str, str] = {
    "first_name": "UserFirstName",
    "last_name": "UserLastName"
}
def get_first_name(full_name: str) -> str:
	return full_name.split(" ")[0]
```

### Interfaces

- raise `NotImplementedError`

```python
class Base(object):
    def virtualMethod(self):
        raise NotImplementedError()
    def usesVirtualMethod(self):
        return self.virtualMethod() + 1

class Derived(Base):
    def virtualMethod(self):
        return 1
```

### String Manipulation

- `mystr.startswith("abc")`, `mystr.endswith("abc")`
- `mystr.split(";")`

### List Comprehension

- ``[youfunc(tmp) for tmp in YOURARRAY if condition(tmp)]`

```python
word_lengths = [len(word) for word in words if word != "the"]
```

### Generators

- using `yield`

```python
import random
def lottery():
    for i in range(6):
        yield random.randint(1, 40)
for random_number in lottery():
       print("And the next number is... %d!" %(random_number))
```

### OOP



```python
class MyClass:
    pass

class MyClass(Base1, Base2):
	__my_private_var = 123
```



