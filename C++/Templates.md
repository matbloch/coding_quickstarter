# Templates



## Understanding Template Type Deduction





## Declaration

```cpp
template <class T>
struct array {
  size_t size_;
  T *data_;
};

```

**Multiple templates**

```cpp
template <class T, class U>
T GetMin (T a, U b) {
  return (a<b?a:b);
}
```

**Forward declaration**

```cpp
template <class T>
class mypair {
    T a, b;
  public:
    T getmax ();
};
```

## Implementation



**1. In header**

- no template instantiation necessary. Compiler can look up which types to generate.

```cpp
template <class T>
T mypair<T>::getmax () {
  T retval;
  retval = a>b? a : b;
  return retval;
}
```

**2. In source file**

```cpp
...
```



// static methods/function arguments







## Specialization

> Implement functionality for a specific type



**Function specialization**

```cpp
template <typename T>
T add(T x, T y)  {
	return x + y;
}

// implementation for chars
template<>
char add<char>(char x, char y) {}
```

**Class specialization**

```c++
template <class T> 
class MyClass { ... };

// specialize hole class
template <> 
class MyClass <char> { ... };

// or, specialize individual methods
template <>
void MyClass<int>::doSomething(int arg) { ... }
```

**Templated member function specialization**

```cpp
class Test {
  public:
    template <typename T>
    void doSomething (T data);
};

template <>
void Test::doSomething<char>(char data) {...}
```



### Partial Spezialization

Partial specialization of a function template, whether it is member 
function template or stand-alone function template, is not allowed by 
the Standard:

```cpp
template<typename T, typename U> void f() {} //okay  - primary template
template<typename T> void f<T,int>() {}      //error - partial specialization
template<> void f<unsigned char,int>() {}    //okay  - full specialization
```

**Workaround**

- partial **class** template spezialization

```cpp
template <class A>
class Thing<A,int>  //partial specialization of the class template
{
    //..
    int doSomething();
};

template <class A>
int Thing<A,int>::doSomething()  { /* do whatever you want to do here */ }
```



### Separating Spezialization Implementation

**What templates are**

So a template is *literally* a template; a class template is *not* a class, it's a recipe for creating a new class for each `T` we encounter. A template cannot be compiled into code, only the result of instantiating the template can be compiled. Templates implement instantiation-style polymorphism.

**Separate compilation**

C++ supports separate compilation where different pieces of the program can be compiled independently through the two stage approach of compilation and then linking. In combination with the requirement for instantiation, template specialisations must be instantiated in the header file.

**Solution**

There's no corresponding code generated if there's no use of its definition, which therefore come up with the first solution. Exposing any type to which you would like your library user to have access can help split up the declaration and implementation.



**Example:** Wrong separation of template declaration and implementation

- foo.h:     declares the interface of `class MyClass<T>`
- foo.cpp: defines the implementation of `class MyClass<T>`
- **bar**.cpp: uses `MyClass<int>`

When compiling *foo.cpp*, the compiler doesn't see *bar.cpp* to see that `MyClass<int>` is needed. It can see `MyClass<T>` but it can't emit code for it (it's a template, not a class). When *bar.cpp* is compile, the compiler can't see the template, only it's interface, defined in *foo.h*.



#### Example: Class-type template

MyClass.h

```cpp
// template definition
template<typename T>
class MyGenericClass {
    public:
    void doSomething(T const& arg);
    T member;
};

// explicit instantiation for the specialized types
template class MyGenericClass<int>;
```

MyClass.cpp

```cpp
#include "a.h"

// specialization
template <>
void MyGenericClass<int>::doSomething(int const & arg) {
    // ...
}
```



#### Example: function-type template

MyClass.h

```cpp
// template definition
class MyGenericClass {
    public:
  	template <typename T>
    void doSomething(T const& arg);
};

// member function template instantiation
template<> void MyGenericClass::doSomething<int> (int const &);
// or by using type inference form the argument
template<> void MyGenericClass::doSomething(int const &);
```

MyClass.cpp

```cpp
#include "a.h"

// specialization
template <>
void MyGenericClass<int>::doSomething(int const & arg) {
    // ...
}
```





## Template Aliases



**Alias Template**

```cpp
template<typename T> 
using pointer = T*;
```





**Template Function Alias**

```cpp
// your templated fn
template<typename T>
void g(T){}

// the templated alias
template<typename T>
const auto f = g<T>;
```

**Alias with specialisation**





## Templated Inheritance

> Inheriting from templated classes



```cpp
class Rectangle: public Area<int> {};
```

**Templated inheritance**

```cpp
template<typename T> class Rectangle: public Area<T> {

};
```

#### Accessing members of superclass

- not automaticall due to two-phase name lookup of compiler
- Options:
  1. `using`
  2. `this`



**Example: **

First option: `using`

```cpp
template<typename T> struct Subclass : public Superclass<T> {
  using Superclass<T>::b;
  using Superclass<T>::g;

  void f() {
    g();
    b = 3;
  }
};
```

Second option: `this`

```cpp
template<typename T> struct Subclass : public Superclass<T> {
  void f() {
    this->g();
    this->b = 3;
  }
};
```

**Inheriting Base Class constructor**

```cpp
template <type T>
class A {
  A(T input);
}

template <type T>
class B : public A<T> {
  using A<T>::A;
}
```

**Initializing templated base class**

```cpp
Bar (const foo_arg_t bar_arg, const a_arg_t a_arg)
: Foo<T>(bar_arg)   // base-class initializer
{

}
```

**Overloading templated base class methods**

```cpp

```





### Parametrized Inheritance

```cpp
template <typename T>
class MyClass : public T {
  public:
  MyClass(int param) : T(param) {}
}
```



## Variadic Templates

- `typename... Ts` to define **template parameter pack**
- To "unpack" parameter packs, use a template function taking one (or more) parameters explicitely and the "rest" of the parameters as a template parameter pack

**Example**

```cpp
template <typename T1, typename T2, ..., typename Tn>
void ignore(T1 t1, T2 t2, ..., Tn tn) {}
```

```cpp
// The base case: we just have a single number.
template <typename T>
double sum(T t) {
  return t;
}
// The recursive case: we take a number, alongside
// some other numbers, and produce their sum.
template <typename T, typename... Rest>
double sum(T t, Rest... rest) {
  return t + sum(rest...);
}
```

### Variadic Arguments

**Processing by recursion**

```cpp
void foo(int);

template<typename ...Args>
void foo(int first, Args... more)
{
   foo(first);
   foo(std::forward(more)...);
}
```



**Iterating over packet arguments**

```cpp
template<typename ...Args>
void foo(int first, Args... more) {
   foo(first);
   for (auto&& x : { more... }) {
		  std::cout << x << std::endl;
	 }
}
```

**passing by reference**



**For references**

```cpp
template <typename ...Args>
int myfunction(Args & ... args) {
  /* ... */
}
```





## Non-type Template Parameters

**Integer template**

```cpp
template<class T, int size> class Myfilebuf
{
  T* filepos;
  static int array[size];
}
```

**Enum template**

```cpp
enum Enum { ALPHA, BETA };

template <Enum E> class Foo {
    // ...
};

template <> void Foo <ALPHA> :: foo () {
    // specialise
}

class Bar : public Foo <BETA> {
    // OK
}
```

**Variadic non-type templates**

```cpp
template <int N, int... Rest>
int max() {
    int tmp = max<Rest...>();
    return N < tmp ? tmp : N;
}
```





## Compile-Time Type Assertion



```cpp
#include <type_traits>
template <class T>
void swap(T& a, T& b)
{
    static_assert(std::is_copy_constructible<T>::value,
                  "Swap requires copying");
    static_assert(std::is_nothrow_copy_constructible<T>::value
               && std::is_nothrow_copy_assignable<T>::value,
                  "Swap requires nothrow copy/assign");
    auto c = b;
    b = a;
    a = c;
}
```





## Examples

### Template method inside template class

```cpp
// .h
template<typename ClassType>
struct Foo{
   template<typename MethodType>
   void g(ClassType i, MethodType j); 
};

// .cpp
template<typename ClassType>
template<typename MethodType>
void Foo<ClassType>::g(ClassType i, MethodType j){}
```





### Calling Method of Templated Base

- [Explanation](https://stackoverflow.com/questions/610245/where-and-why-do-i-have-to-put-the-template-and-typename-keywords)

```cpp
template<typename T>
class base {
public:
    virtual ~base(){}
    template<typename F>
    void foo(){}
}


template<typename T>
class derived : public base<T>{
public:
    void bar(){
        base<T>::template foo<int>();
      // or:
      this->template foo<int>();
    }
};
```



## Template Metaprogramming

- see https://en.cppreference.com/w/cpp/header/type_traits



### std::is_same

> compile-time template evaluation

```cpp
template<class T> double doit(T &t) {
    if constexpr (std::is_same_v<T, AA>)
        return t.Plus(t);
    else
        return t + t;
}
```

**Static assertion**

```cpp
template <typename T>
void myMethod(T input) {
  static_assert(std::is_same<decltype(input), bool>::value, "retval must be bool");
}
```



### std::enable_if - conditional compilation

> Conditionally compile a method

- use `std::enable_if_t` for `std::enable_if<...>::type`

```cpp
template<typename T>
struct Point {
  template<typename U = T>
  typename std::enable_if<std::is_same<U, int>::value>::type
  myFunction(){
    std::cout << "T is int." << std::endl;
  }
  template<typename U = T>
  typename std::enable_if<std::is_same<U, float>::value>::type
  myFunction() {
    std::cout << "T is not int." << std::endl;
  }
};
```

#### Conditional Method Compilation

```cpp
// the template argument
template<class T>
// conditional compilation
typename std::enable_if_t<
  std::is_same<T, int>::value, // the condition
	bool                         // the return type
>
return_something(){
  return true;
}
```

**Overload by return type**

```cpp

template<typename T>
class MyClass {
  using MyTypeToEnableMethod = float;
  
  public:
    template<typename U = T>	// template alias
    static                    // keyword
    // now define the the return type
    typename std::enable_if<
                  std::is_same<U, MyTypeToEnableMethod>::value, // the condition 
                                                                // to enable the fn
                  MyCustomReturnType // the return type if the condition is true
             >::type	               // select the type of the std::enable_if
    my_method(int abc) {
        // ...
    }
}


```

```cpp
template<class T>
struct is_bar
{
    template<class Q = T>
    typename std::enable_if<std::is_same<Q, bar>::value, bool>::type check()
    {
        return true;
    }

    template<class Q = T>
    typename std::enable_if<!std::is_same<Q, bar>::value, bool>::type check()
    {
        return false;
    }
};
```



**Void type methods**

```cpp

```



### std::conditional_t

- conditional type selection based on compile-time boolean

```cpp
template <bool use_floating_point>
void doSomeMath(float a, float b) {
  using T = std::conditional_t<interpolate, float, int>;
  return (T)a + (T)b;
}
```



### std::remove_reference



```cpp
template <typename T>
void method(T& input)
  static_assert(std::is_same<typename std::remove_reference<decltype(input)>::type, bool>::value, "retval must be bool");
}
```



### std::return_type



## Type Traits

> Compile-time type comparison

- see https://en.cppreference.com/w/cpp/header/type_traits



**Storing values of traits**

```cpp
inline constexpr bool is_same_v = is_same<T, U>::value;
```

