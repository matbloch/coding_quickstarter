## Templates

### Regular templates

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



### Template Specialization

```
template <class T> class mycontainer { ... };
template <> class mycontainer <char> { ... };
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







### Template Inheritance



### Variadic Templates

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
int myfunction(Args & ... args)
{
  /* ... */
}
```



### Non-type Template parameters

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

## 