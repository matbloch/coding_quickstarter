

# Python 3



**Resources**

- [!to summarize!](https://python-3-patterns-idioms-test.readthedocs.io/en/latest/PythonDecorators.html)



## PEP 8 and Naming

- Project Structure and Imports

  `from .game_round_settings import GameRoundSettings`

- argument names: `lower_case`









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

#### Tuples

**Unpacking**

```python
(_, abc) = myTuple
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

#### Abstract Methods

```python
from abc import abstractmethod

class MyInterface():
	# abstract
    @abstractmethod
    def get_radius(self):
         """Method that should do something."""
    
    # abstract AND static
    @staticmethod
    @abstractmethod
    def do_something():
         """Method that should do something."""
```



**Overriding Abstract Methods**

> **NOTE:** private methods (starting with `__`) won't be overwritten

```python
class A:
    def f(self):
        print 'a.f'
        self.g()

    def g(self):
        print 'a.g'

class B(A):
    def g(self):
        print 'b.g'
```





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



## Decorators

https://python-3-patterns-idioms-test.readthedocs.io/en/latest/PythonDecorators.html

- overloading methods by argument type

https://docs.python.org/3/library/typing.html#typing.overload





## Context Manager

An object which controls the environment seen in a [`with`](https://docs.python.org/3/reference/compound_stmts.html#with) statement by defining [`__enter__()`](https://docs.python.org/3/reference/datamodel.html#object.__enter__) and [`__exit__()`](https://docs.python.org/3/reference/datamodel.html#object.__exit__) methods.











## Misc / Unsorted



#### Argparse





#### Json

Loading

```python
import json
jsonString = "{'a':'b'}"
jsonData = json.loads(jsonString)
```

Storing

```python
import json
json_string: str = json.dumps({'test': 'abc'})
```

Loading from file

```python
with open('data.txt') as json_file:
    data = json.load(json_file)
```

Storing to file

**TODO**



#### OS Path API

- `os.path.exists`
- `os.path.isfile`
- `os.path.isdir`



#### Enums

```python
from enum import Enum
class Color(Enum):
  RED = 1
  GREEN = 2
  BLUE = 3
```

```python
my_color = Color.RED
my_color.name # 'RED'
my_color.value # 1
```

**from value**

```python
Color(1) # RED
```



**from name**

```python
>>> from enum import Enum
>>> class Build(Enum):
...   debug = 200
...   build = 400
... 
>>> Build['debug']
<Build.debug: 200>
```





#### *args and **kwargs

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



#### Unpacking Arguments

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


