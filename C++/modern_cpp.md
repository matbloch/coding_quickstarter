# C++ Cheatsheet

**Ressources**
- [New C++ language features](https://github.com/AnthonyCalandra/modern-cpp-features#return-type-deduction)

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
- only binds to r values, otherwise makes copy (?)
```cpp
Foo (vector<int> vec) : _member{std::move(vec)} {}
```

**Perfect forwarding**
- constructor for temporary class object is not necessary - pass arguments directly
```cpp
asdf
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





-------------
### Operator Overloading


**Relational Operators**
- Algorithms like `std::sort` expect `operator<` to be defined

```cpp
inline bool operator< (const X& lhs, const X& rhs){ /* do actual comparison */ }
inline bool operator> (const X& lhs, const X& rhs){ return rhs < lhs; }

// or in class:
struct Record
{
	double weight;
    friend bool operator<(const Record& l, const Record& r){
    	return l.weight < r.weight;
    }
}

```




-------------
### `std` library

- `std::accumulate`: Accumulate all values in range
	```cpp
    sum = accumulate(float_vector.begin(), float_vector.end(), 0.0);
    ```
- `std::max_element`: find maximum element
	- hint: overload comparison operator, or provide comparison function

-------------
### `auto` return type

- use `auto`/`const auto` to make reading easier
	- variable that is being declared will be automatically deduced from its initializer.

```cpp
int i = 5;
auto a1 = i;    // value
auto & a2 = i;  // reference
```

## Rvalue References

**rvalues vs lvalues**
- `lvalues`:
	- refers to an object that persists beyond a single expression
	- can appear on both sides of an assignment
	- has a name
	- lvalues refer to a memory location and we can can get memory adress with `&`
	- all variables, including `const` are `lvalues`

- `rvalues`:
	- temporary variable that does not persist beyond the expression that it uses
	- can only appear on the right hand side of an assignment
	- everything that is not an lvalue

```cpp
int x = 3 + 4;	// x: lvalue, (3+4): rvalue
cout << x << endl;
```

**Rvalue References: &&**
Used for:
- Implementing move semantics
- Perfect forwarding

```cpp
void foo(X& x); // lvalue reference overload
void foo(X&& x); // rvalue reference overload
X x;
X foobar();
foo(x); // argument is lvalue: calls foo(X&)
foo(foobar()); // argument is rvalue: calls foo(X&&)
```

- The compiler treats a named rvalue reference as an lvalue and an unnamed rvalue reference as an rvalue
- In `f(const MemoryBlock&)`. This version cannot modify the parameter.
- In `f(MemoryBlock&&)`. This version can modify the parameter.


- `const auto&&` will only bind to rvalue references. In this case you basically just want to say: "my_variable should bind to a (any) reference so I can make sure the return value does not get copied".
- Hence, usually people choose `const auto &` instead of `const auto &&` as it is more concise and 'const auto &&' does not really offer any advantage over 'const auto &&'.


- Wouldn't you always use `auto&&` whenever you want to bind something to a mutable reference? `auto&` only binds lvalue types, hence `auto&&` would be more concise for this case as it allows to bind both `rvalue` and `lvalue` types.

## Pointers

### Pointer Casting
**Up/Downcasting**

```cpp
Parent parent;
Child child;

// upcast - implicit type cast allowed
Parent *pParent = &child;

// downcast - explicit type case required 
Child *pChild =  (Child *) &parent;
```

**Up/Downcasting with shared pointers**
```cpp
class Base {}
class Derived : Base {}

auto basePtr = std::make_shared<Base>();
auto derivedPtr = std::make_shared<Derived>();

// static_pointer_cast to go up class hierarchy
basePtr = std::static_pointer_cast<Base>(derivedPtr);

// dynamic_pointer_cast to go down/across class hierarchy
auto downcastedPtr = std::dynamic_pointer_cast<Derived>(basePtr);
```


### Function Pointers

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

## Templates

- template parameters:
- template arguments: 

### Template Inheritance

### Regular templates

```cpp
template <class T>
struct array {
  size_t x;
  T *ary;
};
```

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

# Argument Passing and Function Returns

- See [This post](http://www.modernescpp.com/index.php/c-core-guidelines-how-to-pass-function-parameters)

- always return by value if possible (complier optimizations make this very fast)
- only as in-out param, if additional sucess parameter is returned

# CMake


`VERBOSE=1 make`

- [tutorial: building and linking libraries](https://github.com/ttroy50/cmake-examples/tree/master/01-basic/C-static-library)


# Polymorphism

**Virtual Destructor on Base Class**
- Otherwise: Destructor of Base is called: Memory Leak

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


# Assertions
- only enabled in debug build
- depends on another macro definition `NDEBUG`

```cpp
#ifdef NDEBUG

#define assert(condition) ((void)0)
#else
#define assert(condition) /*implementation defined*/
#endif
```

```cpp
#include <cassert>
int main() {
    assert(2+2==4);
}
```

# Smart Pointers

**Consuming Unique Ptr**
- `class_variable_(std::move(input));`

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


# Memory Handling

**moving**
```cpp
memmove (str+20,str+15,11);
int a[3] = {1,2,3};
int b[3];
memmove(b, a, sizeof(a));
```


# Function timing

```cpp
template<typename TimeT = std::chrono::milliseconds>
struct measure
{
    template<typename OBJ, typename F, typename ...Args>
    static typename TimeT::rep execution(OBJ obj, F func, Args&&... args)
    {
        auto start = std::chrono::system_clock::now();
        (obj.*func)(std::forward<Args>(args)...);
        auto duration = std::chrono::duration_cast< TimeT>(std::chrono::system_clock::now() - start);
        return duration.count();
    }
};

class A {
	public:
    void test(int a){}
}

typedef void (A::*fnPtrType) (int);
fnPtrType method = &A::test;
A instance_a;
std::cout << measure<>::execution(a, method, 123) << std::endl;
```

# General Design Patterns


# Misc Knowledge



