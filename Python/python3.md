# Python 3



**Resources**

- [!to summarize!](https://python-3-patterns-idioms-test.readthedocs.io/en/latest/PythonDecorators.html)



## PEP 8 and Naming

Project Structure and Imports

`from .game_round_settings import GameRoundSettings`



## Control Structures

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

## Standard Containers

#### Strings

`mystr.startswith("abc")`

`mystr.endswith("abc")`

``mystr.split(";")`

```
name = "Emil"
age = 63
f"Hello, {name}. You are {age}."
```

#### Lists

**List Comprehension**

- `[youfunc(tmp) for tmp in YOURARRAY if condition(tmp)]`

```python
word_lengths = [len(word) for word in words if word != "the"]
```

## Type Checking

- [Type checking](https://realpython.com/python-type-checking/)

**Type Systems**

- **Dynamic Typing:** Type only checked at runtime
- **Static Typing:** Type checking at compile time
  - Python will remain dynamically typed language but type hints have been introduced
- **Duck Typing:** Focussing on how object behaves, rather than its type/class *"If it talks and walks like a duck, then it is a duck"*

### Type Hints and Annotations

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

**Type Aliases**

```python
from typing import List, Tuple

Card = Tuple[str, str]
Deck = List[Card]
```

**Any Type**

```python
import random
from typing import Any, Sequence

def choose(items: Sequence[Any]) -> Any:
    return random.choice(items)
```

**Forward Hints**

- use quotation marks for forward type declarations 

```python
class Tree:
    def leaves(self) -> List['Tree']:
      ...
```



### Static Type Checking

- Through type annotations
- [Mypy](http://www.mypy-lang.org/): Runs VM and does type checking with almost no overhead



### Runtime Type Checking

- rather not recommended

```python
assert isinstance(foo, Set[int]), 'Wrong type'
```





## Object Oriented Programming

```python
class MyClass:
    pass

class MyClass(Base):
  # static variables
	__private_class_attribute = 123
  class_attribute = 'abc'

  # Initializer / Instance Attributes
  def __init__(self, name, age):
    # assigning instance attributes
    self.name = name
    self.age = age
    # call constructor of parent class
    super().__init__(name)
    
  def call_super_method(self):
    return super().baz()
    
  # static method
  @staticmethod
	def info(name, email, username):
    pass
        
  # class methods: work with the class itself (e.g. for factory methods)
  @classmethod
  def all(cls):
     return db.session.query(cls).all()
```

### Interface and Protocols

#### ABCs: Formal Interfaces

```python
import abc

class Bird(abc.ABC):
    @abc.abstractmethod
    def fly(self):
        pass
```

#### Duck Typing

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

**Abstract Methods**

```python
import abc

class MyInterface():
    __metaclass__  = abc.ABCMeta
    @abc.abstractmethod
    def get_radius(self):
         """Method that should do something."""

# or
class MyInterface2(metaclass=abc.ABCMeta):
    @abc.abstractmethod
    def get_radius(self):
         """Method that should do something."""
    
    # static abstract
    @staticmethod
    @abc.abstractmethod
    def create():
      """E.g. a factory method"""
```



## Generators

- using `yield`

```python
import random
def lottery():
    for i in range(6):
        yield random.randint(1, 40)
for random_number in lottery():
       print("And the next number is... %d!" %(random_number))
```



## Decorators

https://python-3-patterns-idioms-test.readthedocs.io/en/latest/PythonDecorators.html





## *args and **kwargs

***args**

- Variable number of arguments

```python
def test_var_args(f_arg, *argv):
    print("first normal arg:", f_arg)
    for arg in argv:
        print("another arg through *argv:", arg)

test_var_args('yasoob', 'python', 'eggs', 'test')
```

***\*kwargs**

- keyworded variable length of arguments

```python
def greet_me(**kwargs):
    for key, value in kwargs.items():
        print("{0} = {1}".format(key, value))
```



### Unpacking Arguments

```python
def test_args_kwargs(arg1, arg2, arg3):
    print("arg1:", arg1)
    print("arg2:", arg2)
    print("arg3:", arg3)
    
# list: Tuple input
args = ("two", 3, 5)
test_args_kwargs(*args)
    
# keyworded: Dict input
kwargs = {"arg3": 3, "arg2": "two", "arg1": 5}
test_args_kwargs(**kwargs)
```

Order of declaration

```python
some_func(fargs, *args, **kwargs)
```

