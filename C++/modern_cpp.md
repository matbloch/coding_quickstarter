# Modern C++

**Ressources**
- [New C++ language features](https://github.com/AnthonyCalandra/modern-cpp-features#return-type-deduction)

**TODO**

- [Topics to cover](https://www.amazon.com/Effective-Modern-Specific-Ways-Improve/dp/1491903996#reader_1491903996)

# Misc

**Range-based for loop**
```cpp
for (const auto &i : vector) {}
```
**emplace_back**
- Use `emplace_back` if you pass a constructor (allows to move)
	```cpp
    vec.emplace_back(std::string("Hello"))
  ```
- Also for perfect forwarding (allows to directly call the constructor on the actual memory location inside the vector). To do so, remove implicit constructor call, e.g. `MyObj(` and just pass the arguments into `emplace_back`
    ```cpp
    std::vector<MyClass> v;
    v.push_back(MyClass(2, 3.14f));
    v.emplace_back(2, 3.14f);
    ```

**reserve**
Instead of:
```cpp
const size_t size = 3;
std::vector<MyClass> result(size);
result.push_back(MyClass(arg1, arg2));
```
Do:
```cpp
const size_t size = 3;
std::vector<MyClass> result;
result.reserve(size);
result.emplace_back(arg1, arg2);
```

**complex `const` initialization**
```cpp
const SbVector2f check_dir = [&center_0, &center_1] {
    SbVector2f dir = center_1 - center_0;
    dir.normalizeL2();
    return dir;
}();
```


**Move Semantics**
- only binds to r values, otherwise makes copy
```cpp
Foo (vector<int> vec) : _member{std::move(vec)} {}
```

**Perfect forwarding**
- constructor for temporary class object is not necessary - pass arguments directly
```cpp
...
```

**Anonymous functions**

- use `static` or anonymous namespace

```cpp
static void my_func(){}
namespace {
	void my_func(){}
}
```

**`explicite` Constructor**
- prevents copy initialization. E.g:

```cpp
    class B {
        explicite B(int){}
    }
    // B b1 = 1; // NOT ALLOWED
```

**`static` and `constexpr`**

- `static`
  - must be initialized before the program starts
  - has to be thread-safe
  - initialization order is undefined
- `constexpr` 
  - forces constant compile-time initialisation
  - all other static variables are zero initialized
  - shouldn't have non-trivial destructior (e.g. freeing of memory). e.g. for `std::string`

...

- https://stackoverflow.com/questions/14116003/difference-between-constexpr-and-const



### Braced Initialization

- braced initialisation: https://blog.quasardb.net/2017/03/05/cpp-braced-initialization



-------------
### `std` library

- `std::accumulate`: Accumulate all values in range
	
  ```cpp
  sum = accumulate(float_vector.begin(), float_vector.end(), 0.0);
  ```
- `std::max_element`: find maximum element

  - hint: overload comparison operator, or provide comparison function

```cpp
static bool abs_compare(int a, int b) {
    return (std::abs(a) < std::abs(b));
}
auto result = std::max_element(v.begin(), v.end(), abs_compare);
```

```cpp
// iterator of MyCustomType is convertable to uint16_t
std::vector<MyCustomType> v;
uint16_t result = std::max_element<uint16_t>(v.begin(), v.end());
```





-------------
### `auto` return type

- use `auto`/`const auto` to make reading easier
	- variable that is being declared will be automatically deduced from its initializer.

```cpp
int i = 5;
auto a1 = i;    // value
auto & a2 = i;  // reference
```

- use `decltype` to refer to the type declared by `auto`

```cpp
auto result = do_something();
result = decltype(result)(so_something_else());
```

## Function Pointers

```cpp
class A {
	bool (A::*my_fn_ptr_) (int, float) = &A::do_this;
    bool do_this(int a, float b) {
    }
}
```


**define function pointer**
```cpp
int (*FuncPtr)(int);
typedef int (*FuncPtr)(int); 
```

**Member function pointers**
```cpp
int (MyClass::*MyTypedef)( int); //MyTypedef is a variable
typedef int (MyClass::*MyTypedef)( int); //MyTypedef is a type!

using MemberFn = bool (DataMask::*)(size_t, size_t) const;
using MemberFn = bool (*)(size_t, size_t);
```


**Example**: Regular function

```cpp
float do_smth(int a, double b) {}
typedef float (*MyFuncPtrType)(int, double);
MyFuncPtrType my_func_ptr = do_smth;
(*my_func_ptr)(7, 3.14159);
```

**Example**: Ptr to non-static method (without arguments)

```cpp
class T {
	void MethodA(int a){
}
typedef void (T::*MethodPtrType) (int); // define ptr type "MethodPtr"
MethodPtrType method = &T::MethodA; // create ptr
T *obj = new T();					// allocate object
(obj->*method)(123);					// execute fn via ptr
// or:
T obj2;
(T.*method)(123);
```


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



## Custom Iterators

- `std::iterator` is deprecated
- do defines manually (see `std::iterator` implementation)

```cpp

struct Iterator {
  public:
  using value_type = float;
  using difference_type = ptrdiff_t;
  using pointer = float*;
  using reference = float&;
  using iterator_category = std::input_iterator_tag;

  Iterator(const CustomValueContainer *items, int index) :
  items_(items), current_index_(index) {
  }

  Iterator& operator++() {
    index_++;
    return *this;
  }

  Iterator operator++(int) {
    Iterator result(*this);
    ++(*this);
    return result;
  }

  bool operator==(const Iterator &rhs) const {
    return items_ == rhs.items_ && current_index_ == rhs.current_index_;
  }

  bool operator!=(const Iterator &rhs) const {
    return !(*this == rhs);
  }

  float operator*() const {
    return (*items_)[index_];
  }

  private:
    const CustomValueContainer *items_;
    int current_index_;
};
```



# Argument Passing and Function Returns

- See [Guideline on argument passing](http://www.modernescpp.com/index.php/c-core-guidelines-how-to-pass-function-parameters)
- always return by value if possible (complier optimizations make this very fast)
- only as in-out param, if additional sucess parameter is returned



**Passing Arguments**

- small values: `const` reference
- special types: 




# Polymorphism

**Virtual Destructor on Base Class**
- When deleting instance of **derived** class through **base** class pointer
  - Just base class destructor is called: Memory leak

```cpp
class Interface {
   virtual void doSomething() = 0;
   // we would need virtual ~Interface() = default; here
};

class Derived : public Interface {
   Derived();
   ~Derived() { .. cleanup ..}
};

void myFunc(void)
{
   Interface* p = new Derived();
   // The behaviour of the next line is undefined. It probably 
   // calls Interface::~Interface, not Derived::~Derived
   delete p; 
}
```

**Pointer to a base class**

- `std::unique_ptr<base> derived = std::make_unique<Derived>();`
- `Base* derived = new Derived();`



# Preprocessor Directives

- subtracted at compile time

**In-code definition**
```cpp
#define WIDTH       80
#define LENGTH      ( WIDTH + 10 )
```

**Using Preprocessor Definitions** (e.g. in CMake)
Generally:
```cpp
add_definitions(-DWIDTH=80)
```
For specific targets:
```cpp
target_compile_definitions(my_target PRIVATE FOO=1 BAR=1)
```



# Misc Knowledge



### std::function

- general-purpose function wrapper
- Instances of `std::function` can store, copy and invoke any Callable target (functions, lambda expressions, pointers to member functions, data member accessors ...)



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

**Static member function**

```cpp
std::function<void(int)> f_add_display = std::bind(&Foo::foo_static);
```



**std::function with templates and lambdas**

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







### Reference Wrappers

`std::reference_wrapper<T>`

- used as a mechanism to store references inside **standard** containers (like **std::**vector) which cannot normally hold references.

```cpp
class MyClass
{
public:
    MyClass& operator=(MyClass const& other)
    {
        ???
    }
    // ...
private:
    T& reference;
};
```

What should `operator=` do? The natural thing would be to make `reference` point to the same object as `other.reference` does,
but references can’t rebind. For this reason, the compiler gives up and
doesn’t implement a default assignment operator in this case.



```
T object1;
auto reference = std::ref(object1); // reference is of type std::reference_wrapper<T>
T object2;
reference = std::ref(object2); // reference now points to object2
// object 1 hasn't changed
```

Returning references instead of pointers: make it clear that caller is not responsible for lifetime management:

```cpp
std::vector<std::reference_wrapper<Foo>> Bar::getFoos() const {
  std::vector<std::reference_wrapper<Foo>> fooRefs;
  for (auto &ptr : foos) {
    fooRefs.push_back(std::ref(*ptr));
  }
  return fooRefs;
}
```



### Using Pairs for std::map keys

- `operator<` needs to be defined for map key
- is defined for `std::pair`

```cpp
template <class T1, class T2>
  bool operator<  (const pair<T1,T2>& lhs, const pair<T1,T2>& rhs)
{ return lhs.first<rhs.first || (!(rhs.first<lhs.first) && lhs.second<rhs.second); }
```



### Comparison Operator for Structs

- `std::tie` packs references to the arguments in a temporary struct for which a comparison operator is defined

```cpp
struct data {
    bool operator!=(const data& p_rhs) const {
        return std::tie(x, y) != std::tie(p_rhs.x, p_rhs.y);
    }
    int x, y;
};
```







### Braced List Initialization



**In combination with Templates**

- braced lists are not deducible (with an exception for `auto` declarations), and so you cannot instantiate the function template when that missing parameter type.

```cpp
std::make_unique<MyClass>({"a", "b"});
```

Would work:

```cpp
auto input = {"a", "b"};
std::make_unique<MyClass>(input);
```





## Pittfalls

### Temporaries in Range-based for loops

- range based for loop gets constructed as  `auto && val = A().get();`
- `A()` is destroyed after construction

```cpp
class A {
  int a_;
  const &getA() {return a_;}
}

for (auto v : A().getA()) {}
```



