# C++ Object Oriented Programming

## Class Definition



#### Forward Declaration

- Include/definition order: compiler needs to know class memory layout
- Benefits
  - Speed up build time
  - Dependency breaking
- Downsides
  - Google style gide recommends againt using forward declarations
  - Forward declaration can easily become redundant wen api changes

```cpp
// forward declaration
class Line {
   public:
  		explicit Line(double len);
      void setLength(double len);
      double getLength() const;
   private:
      double length_;
};

// implementation
Line::Line( double len): length_(len) {}
void Line::setLength(double len) { length_ = len; }
double Line::getLength(double len) const { return length_; }
```



**Nested Forward Declaration**

- not possible
- workarounds:
  - make class non-nested
  - create common base class
  - ...



## Member Initialization

**Initialization Order**

1. `virtual` base classes
2. direct base classes (depth-first)
3. nonstatic data members, in order of declaration in the class definition
   - also applies to initializer list
4. body of constructor



#### Pittfalls

```cpp
class A : public B {
  public:
  // base classes are initialized before members - "a_member" is not initialized
  A(): B(a_member), a_member(123) {}
  int a_member;
}
```



### Initialization Types

- initializer list just specifies values and base class constructors
  - order of initialization not changed
  - order of initilizer list should be canonical to prevent reading from uninitialized memory



##### Method 1: Class constructor

##### Method 2: Initialization list

- If a member class does not have a default constructor: It **MUST** be initialized wth an initialization list

```cpp
class A
{
    public:
        A() { x = 0; }
        A(int x_) { x = x_; }
        int x;
};
// Default Constructor of A is called anyways
class B
{
    public:
        B(){a.x = 3;}
    private:
        A a;
};
```

##### Method 3: Assignment

### 



## Inheritance

**Calling Child method from parent**





## Constructors

### Copy constructors

**Compiler provided copy constructor**

```cpp
class MyClass {
  int x;
  char c;
  std::string s;
};
```
```cpp
MyClass::MyClass( const MyClass& other ) :
   x( other.x ), c( other.c ), s( other.s ) {}
```

**Explicit auto-generation**

```cpp
MyClass(MyClass const&) = default;
```

**Manual Implementation**

```cpp
MyClass::MyClass( const MyClass& other ) :
   x( other.x ), c( other.c ), s( other.s ) {}
```

**Overloads for `const &` members**

- simple solution: if needs to support assignment, use ptr instead of references (can create pointer from reference)



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











## Common Patterns

### Base Class Container

- Collect multiple derived classes in common vector of base class point type

```cpp
#include <iostream>
#include <vector>
using namespace std;

class a
{
protected:
    int test;
public:
    virtual void SetTest(int arg) {test = arg;}
    int GetTest() {return test;}
};

class b : public a
{
public:
    void SetTest(int arg) {test = arg+1;}
};

class c : public a
{
public:
    void SetTest(int arg) {test = arg+2;}
};

int main()
{
    vector<a *> derivedClassHolder;
    derivedClassHolder.push_back(new b);
    derivedClassHolder.push_back(new c);

    for(int i = 0; i < (int)derivedClassHolder.size() ; i++)
    {
        derivedClassHolder[i]->SetTest(5);
    }

    for(int i = 0; i < (int) derivedClassHolder.size() ; i++)
    {
        cout << derivedClassHolder[i]->GetTest() << "  ";
    }
    return 0;
}

```
