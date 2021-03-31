# Lifetime

> Every [object](https://en.cppreference.com/w/cpp/language/object) and [reference](https://en.cppreference.com/w/cpp/language/reference) has a *lifetime*, which is a runtime property: for any object or reference, there is a point of execution of a program when its lifetime begins, and there is a moment when it ends.

See https://en.cppreference.com/w/cpp/language/lifetime



### Implicit-lifetime types

- 





## Storage Reuse





## Reference Lifetime Extension

In short, lifetimes of temporaries (referents) will be extended *if and only if*:

- A local `const T&` (or `T&&`, although Google style generally ignores that) is initialized to the result of an expression (usually a function call) returning a temporary `T` *or* the `T` subobject of a temporary (e.g. a struct containing `T`).



## Temporary Object Lifetime

- temporary bound to a reference parameter in a function call exists until the end of the full expressions containing that function call
  - if function returns a reference which outlives the full expression, it becomes a dangling reference
- temporary bound to a `return` value of a function is not extended: It is destroyed immediately at the end of the return expression.
- temporary bound to a reference member in a constructor initializer list persists only until the constructor exits, not as long as the object exists
- lifetime extension is not transitive through a function argument (see example below)

**Exceptions**

- lifetime is extended by binding to a `const` `lvalue` reference or to an `rvalue` `reference`
- (default argument temporaries of default/copy constructor used to initialize element of array ends before the next element of the array begins initialisation)





### Extending lifetime by `const &`

- The C++ standard *guarantees* that binding a temporary to a `const` reference on the **stack**, extends the lifetime of the temporary to the lifetime of the const reference.
- only `direct` reference to temporary objects, not reference obtained via (nested) functions (can e.g. be modified by constructor, i.e. not save)





1. Any access to the nested state **via a function (member or free)** disables lifetime extension of the parent. For example `Person().GetName().first_name` would no longer trigger lifetime extension of the temporary `Person`.
2. As a corollary, any conversion member functions, chained member functions do not extend the lifetime of the original temporary.



**Binding References to Rvalues is illegal**

```cpp
std::string GetString() {
    return "A string";
}
void SomeFunction() {
    Person person(&GetString());  // Error: taking address of temporary [-fpermissive]
    std::cout << person.GetName();
}
```







### Extended

- Temporary returned by function expression

```cpp
T f(const char* s) { return T(s) }
const T& good = f("Ok")
```

- Temporary constructed by simple expression

```cpp
const T& good = T("Ok");
```

- Temporary returned by function expression

```cpp
int GetInt() {
    int x = 1;
    return x;
}
const int& good = GetInt();
```





### Gotchas

**Examples**

- Temporary returned by chained function

```cpp
const T& bad = f("Bad!").Member();
```

**const & in constructor**

```cpp
class A {
public:
    A(string const& n) : member(n) {}
    string const& member;
};
```

Invalid memory access:

- `const &` is bound to constructor argument `n` and becomes invalid when `n` goes out of scope

```c++
auto a = A("abc");
a.member;
```

Works: Liftetime prolonged until expression ends 

- temporary only destroyed at the end of full expression - `.member` is a read expression and temporary is still alive.

```cpp
std::cout << A("abc").member;
```

How to resolve:

Store copy of `member` instead of reference



### Polymorphism and Lifetime Extension

- when taking `const &` to base class, `Base` class destructor will also be called, even if not virtual

```cpp
class Base {
    ~Base() { std::cout << "Base dtor\n"; }
};
class Foo : public Base {
    // Note: No virtual dtors
    ~Foo() { std::cout << "Foo dtor\n"; }
};

Base return_base() { return {}; }
Foo  return_foo()  { return {}; }
```

```cpp
const Base &b {return_foo()};
// Foo dtor
// Base dtor
```



