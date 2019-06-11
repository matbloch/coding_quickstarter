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



## Member Initialization

**Call order**:

- Initialization list
- Constructor Body

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







## Polymorphism - Base Class Container

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
    derivedClassHolder.push_back(new a);
    derivedClassHolder.push_back(new c);
    derivedClassHolder.push_back(new b);

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
