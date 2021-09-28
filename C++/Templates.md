# Templates



## Understanding Template Type Deduction





## Template Declaration

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

template <class T>
T mypair<T>::getmax () {
  T retval;
  retval = a>b? a : b;
  return retval;
}
```



## Template Specialization

> Implement functionality for a specific type

**Function specialization**

```cpp
template <typename T>
T add(T x, T y)  {
	return x + y;
}

// implementation for chars
template<>
char add<char>(char x, char y) {
	...
}
```

**Class specialization**

```c++
template <class T> 
class mycontainer { ... };

template <> 
class mycontainer <char> { ... };
```

```cpp
// Normal class
template <typename T>
class A
{
public:
	A(){ cout << "A()\n"; }
	T add(T x, T y);
};

template <typename T>
T A<T>::add(T x, T y) {
	return x+y;
}
// Specialized class
template <>
class A <char>
{
public:
	A() { cout << "Special A()\n"; }
	char add(char x, char y);
};

// template <>   <= this is not needed if defined outside of class
char A<char>::add(char x, char y)
{
	int i = x-'0';
	int j = y-'0';
	return i+j;
}
```

**Member function specialization**

Test.h

```cpp
class Test {
  public:
    template <typename T>
    void function (T data) {
      std::cout << data;
    }
};

template <>
void Test::function<char>(char data);
```

Test.cpp

```cpp
template <>
void Test::function<char>(char data) {...}
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





## Inheritance

```cpp
class Rectangle: public Area<int> {};
```

**Templated inheritance**

```cpp
template<typename T> class Rectangle: public Area<T> {

};
```

**Accessing members of superclass**

- not automaticall due to two-phase name lookup of compiler

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

**For references**

```cpp
template <typename ...Args>
int myfunction(Args & ... args) {
  /* ... */
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



### Enable_if

> Conditionally compile a method

```cpp
template<typename T>
struct Point
{
  template<typename U = T>
  typename std::enable_if<std::is_same<U, int>::value>::type
    MyFunction()
  {
    std::cout << "T is int." << std::endl;
  }

  template<typename U = T>
  typename std::enable_if<std::is_same<U, float>::value>::type
    MyFunction()
  {
    std::cout << "T is not int." << std::endl;
  }
};
```



**Conditional Method definition**



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





#### Conditional Method Compilation

**Overload by return type**

```cpp

template<typename T>
class MyClass {
  using MyTypeToEnableMethod = float;
  
  public:
    template<typename U = T>	// template alias
    static                              // keyword
    // the return type
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

