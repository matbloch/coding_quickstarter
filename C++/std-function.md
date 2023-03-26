# std::function and Lambdas



- general-purpose function wrapper
- Instances of `std::function` can store, copy and invoke any Callable target (functions, lambda expressions, pointers to member functions, data member accessors ...)



## Assignment

**Storing free functions**

```cpp
void print_num(int i){
    std::cout << i << '\n';
}
// store a free function
std::function<void(int)> f_display = print_num;
f_display(-9);
```

**Storing member function**

- non-static member function must be called with an object

```cpp
struct Foo {
    Foo(int num) : num_(num) {}
    void print_add(int i) const { std::cout << num_+i << '\n'; }
    int num_;
};

// A. Store call to member function
std::function<void(const Foo&, int)> f_add_display = &Foo::print_add;
const Foo foo(314159);
// Option A.1: call with instance
f_add_display(foo, 1);
// Option A.2: create new instance
f_add_display(314159, 1);

// B. Store call to member function and instance
using std::placeholders::_1;
// Note: if method has arguments, use placeholders
std::function<void(const Foo&, int)> f_add_display = std::bind(&Foo::print_add, foo, _1);
```

**Binding to static member function**

```cpp
std::function<void(int)> my_lambda = std::bind(&Foo::foo_static);
```

**Null initialization**

```cpp
std::function<void(int)> may_lambda = nullptr;
```



## std::function with templates and lambdas

- lambda is not a `std::function`
- template deduction looks through limited set of implicit conversion

Option 1: Template whole function

```cpp
template <typename T, typename F>
T test2(T arg, F mapfn) {
  return mapfn(arg);
}
```

Option 2: Put `std::function<T(T)>` in non-deduced context

```cpp
template <typename T> struct identity { using type = T; };
template <typename T> using non_deduced = typename identity<T>::type;

template <typename T>
T test2(T arg, non_deduced<std::function<T (T)>> mapfn) {
  return mapfn(arg);
}
```

**templated function argument with default**

```cpp
template <typename InputType, typename F = void(InputType)>
void doSomething(InputType input, F = [](InputType){
  // do something...
})

```

**Capturing Scopes**

- local variables can be captured by reference or by value
- ❗️**! Caution ! ** capturing local variables that go out of scope before the labmda is executed might lead to issues

```cpp
int my_variable_to_copy = 3;
auto lambda = [my_variable_to_copy]() {
  // my_variable_to_copy is captured by value/copied
};
```

**example:** Captured variables run out of scope

```cpp
std::function<void(int)> generateLambda(int input) {
  return [&]() {
    // input will go out of scope before lambda is executed
    return input;
  };
}
```





## Lambdas

