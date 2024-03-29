# Type Checking and Assertions

- [Type checking](https://realpython.com/python-type-checking/)

**Type Systems**

- **Dynamic Typing:** Type only checked at runtime
- **Static Typing:** Type checking at compile time
  - Python will remain dynamically typed language but type hints have been introduced
- **Duck-Typing:** Focussing on how object behaves, rather than its type/class *"If it talks and walks like a duck, then it is a duck"*.  By emphasizing interfaces rather than specific types, well-designed code improves its flexibility by allowing polymorphic substitution.



## Static Type Checking

- Through type annotations
- [Mypy](http://www.mypy-lang.org/): Runs VM and does type checking with almost no overhead



## Runtime Type Checking

- rather not recommended

```python
assert isinstance(foo, Set[int]), 'Wrong type'
```



## Type Hints and Annotations

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



### Best Practices



**classes**



```python
class MyClass:
  # non-class variable
  x: int
  def __init__():
  	self.x = 123
```



