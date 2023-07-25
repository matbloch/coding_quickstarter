# Lambdas and std::function



## Lambdas



`[capture clause] (parameters) -> return-type {body}`

**Capture Clause**

- `[=]` capture all of the variables from the enclosing scope by value
- `[&]` capture all of the variables from the enclosing scope by reference
- `[this]` capture all of the data members of the enclosing class
- `[a, &b]` a by copy, b by reference
- `[]` no external variables

**Parameters**


### Usage

**Store in variable**
`auto factorial = [](int i, int j) {return i * j;};`

**Const variable assignment**

```cpp
const int my_var = [&normal]() {
	if (normal.x() > 3) {
    	return 2;
    }
    return 3;
}();
```

**Member variables in capture list**

```cpp
const int my_var = [this]() {
	if (this.x() > 3) {
    	return 2;
    }
    return 3;
}();
```


**Lambdas as Function Parameters**

```cpp
template <typename T>
void call(T);

int main() {
  auto fn = []() { cout<<"Lambda"<<endl; };
  call(fn);
  return 0;
}

template <typename T>
void call(T fn) {
  fn();
}
```

**Capture current scope as reference**

```cpp
const int myVariable = [&] {
    if (bCondition)
        return bCond ? computeFunc(inputParam) : 0;
    else
       return inputParam * 2;
}();
```

**❗caution❗️**

- lambda shall not outlive any of its reference captured objects (use copy instead)

Bad example:

```cpp
auto g() {
  int i = 12;
  return [&] {
    i = 100;
    return i;
  };
}
```







## std::function

- general-purpose function wrapper
- Acts as a type erazure: Instances of `std::function` can store, copy and invoke any Callable target (functions, lambda expressions, pointers to member functions, data member accessors ...)



**Null initialization**

```cpp
std::function<void(int)> may_lambda = nullptr;
```



**Storing free functions**

```cpp
void print_num(int i){
    std::cout << i << '\n';
}
// store a free function
std::function<void(int)> f_display = print_num;
f_display(-9);
```



#### Binding (`std::bind`)

- creates a temporary function
- **NOTE:** deprecated in favor for lamda's

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



## std::function with templates and lambdas

- lambda is **not** a `std::function`
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


