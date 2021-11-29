# OOP



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

## Interface and Protocols

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





## Multiple Inheritance







## Misc







### super()

- `__init__()` is automatically invoked upon class instance creation
- If child class defines `__init__()`, it has to **explicitly** call the child class constructor
- if child does not implement `__init__()` the parent class constructor will be called automatically

```python
super(ParentClass, self).__init__(num)
```





