# C++ Object Oriented Programming

## Class Definition

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



#### Forward Declaration

- Include/definition order: compiler needs to know class memory layout
- Benefits
  - Speed up build time
  - Dependency breaking
- Downsides
  - Google style gide recommends againt using forward declarations
  - Forward declaration can easily become redundant wen api changes



**Nested Forward Declaration**

- not possible
- workarounds:
  - make class non-nested
  - create common base class
  - ...



## Member Initialization



**Initialization Order**

1. `virtual` base classes
2. direct base classes
3. nonstatic data members, in order of class definition
4. body of constructor



### Initialization Types

- initializer list just specifies values and base class constructors
  - order of initialization not changed
  - order of initilizer list should be canonical to prevent reading from uninitialized memory





#### Method 1: Class constructor

#### Method 2: Initialization list

- If a member class does not have a default constructor: It MUST be initialized wth an initialization list

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

#### Method 3: Assignment

### 



## Inheritance

**Calling Child method from parent**











## Constructors

### Copy constructors

```cpp
MyClass( MyClass* other );
MyClass( const MyClass* other );

// leads to infinite loop!
MyClass( MyClass other );
```

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
 x( other.x ), c( other.c ), s( other.s )
{}
```

### Overloads for `const &` members

- simple solution: if needs to support assignment, use ptr instead of references (can create pointer from reference)



**Copy Constructor**

Let compiler generate it:
```cpp
ModelRecorder(const ModelRecorder&) = default;
```
Own implementation:
```cpp
ModelRecorder(const ModelRecorder& arg)
    :CompositionalModel{arg}, modelRef_{arg.modelRef_} {}
```

**Assignment Operator**





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
