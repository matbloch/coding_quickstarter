# Polymorphism



**Calling Child method from parent**







## Virtual Classes

**The `virtual` keyword:**

- `virtual` methods can be overriden in derived classes
- if derived class is handled by a reference to the base class: behaviour is still taken from **derived** class
- overriden `virtual` methods are also `virtual`
- Use `final` to prevent further overriding



- `override` keyword on child class implementation verifies that the function actually implements a virtual method

- if base class method is not `virtual` the implementation is **hiding** it
  - Thus: `override` needs `virtual` base method

- `virtual ` only for non-static





### Preventing Memory Leaks

- when calling `delete` to pointer of base class, destructor of derived class **is not called!**
- add `virtual` destructor if class has at list one `virtual` method



```cpp
class ISample {
  public:
  virtual ISample() = default;
  virtual void doSomething();
}
```







### Calling `virtual` Child Method in Parent

```cpp
class A {
  public:
  virtual void do();
  void go() {
    do();
  }
}
class B : public A {
  public:
  // this will override call go from A
  virtual void do();
}

A* obj = new B;
B->go();
```



### Calling `virtual` Base Method in Child

```cpp
class Bar : public Foo {
  void printStuff() override {
    Foo::printStuff(); // calls base class' function
  }
};
```



### Calling `virtual` Method in Constructor

Calling virtual functions from a constructor or destructor is dangerous  and should be avoided whenever possible.  All C++ implementations should call the version of the function defined at the level of the hierarchy  in the current constructor and no further.

The reason is that C++ objects are constructed like onions, from the  inside out. Base classes are constructed before derived classes. So,  before a B can be made, an A must be made. When A's constructor is  called, it's not a B yet, so the virtual function table still has the  entry for A's copy of fn().



**Workaround:** Factory

```cpp
class Object {
public:
  virtual void afterConstruction() {}
};

template<class C>
C* ObjectFactory() {
  C* pObject = new C();
  pObject->afterConstruction();
  return pObject;
}
```

Usage

```cpp
class MyClass : public Object {
public:
  virtual void afterConstruction() {}
};

auto obj = ObjectFactory<MyClass>();
```





