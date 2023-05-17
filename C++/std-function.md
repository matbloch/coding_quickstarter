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

**Binding an external member function**

- non-static member function must be called with an object



**Binding to member function**

- use a lambda (looks nicer) or `std::bind`

```cpp
class MyClass {
      MyClass() : myFunction_([this](int arg1, int arg2) { 
        return myMemberFunction(arg1, arg2); 
      }) {
        // ... rest of the constructor
    }
  private:
    std::function<int(int, int)> myFunction_;
}
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

