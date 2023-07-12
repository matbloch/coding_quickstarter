

# Python 3



**Resources**

- [!to summarize!](https://python-3-patterns-idioms-test.readthedocs.io/en/latest/PythonDecorators.html)



## PEP 8 and Naming Conventions

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

`mystr.split(";")`

```
name = "Emil"
age = 63
print(f"Hello, {name}. You are {age}.")

what = "free_lunch"
when = date(2023, 6, 28)
print(f"Attend {what=} {when=}")
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









## Misc / Unsorted



#### Data Classes





#### Mutable Default Arguments

"*Python’s default arguments are evaluated once when the function is  defined, not each time the function is called (like it is in say, Ruby). This means that if you use a mutable default argument and mutate it,  you will and have mutated that object for all future calls to the  function as well*"

```python
def foo(element, to=None):
    if to is None:
        to = []
    to.append(element)
    return to
```





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

