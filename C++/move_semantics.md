# C++ 11 Move Semantics



## Default Containers

**vector**

- vector will be empty after move

`A = std::move(B);`



## R- and L-Values

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





## Copy Elision and Pass-by-Value

> Copy elision is an optimization implemented by most compilers to prevent extra (potentially expensive) copies in certain situations. It makes  returning by value or pass-by-value feasible in practice (restrictions  apply).

- Copiler constructs objects already in reserved future memory location ("in-place-construction")
- With each copy elision, one construction and one matching destruction of the copy are omitted, thus saving CPU time, and one object is not  created, thus saving space on the stack frame.



### Common Forms of Copy Elision

**Named Return Value Optimization (NRVO)**

- if named non-`const` object with automatic storage duration is returned
- copy/move is elided: compiler generates `a` already in the place that is reserved for the return value
- `std::move` can make things worse

```cpp
A foo() {
  A a=...;
  ...
  return a;
}
```

**Return Value Optimization (RVO)**

- when a temporary is returned

```cpp
A foo() {
  return A();
}
```

**Temporary passed by value**

```cpp
foo(A());
```



### Mandatory and non-mandatory Copy Elision

- Copy/move-constructors are not called consistently
- No critical logic inside copy/move-constructors or destructors



#### Mandatory copy/move elision (since C++17)

- In a return statement where the operand is an `rvalue` of the same class type as the function return type

```cpp
T f() {
    return T();
}
f(); // only one call to default constructor of T
```

#### Non-mandatory elision of copy/move

```cpp
struct C {
  C() {}
  C(const C&) { std::cout << "A copy was made.\n"; }
};
 
C f() {
  return C();
}
```



```cpp
C obj = f();
```



Possible outputs (dependent on compiler):


- <nothing>
  
  - both copy operations elided
- ```cpp
  "A copy was made"
  ```
  - one copy is optimised/elided (propbably the `return` copy)
- ```cpp
  "A copy was made"
  "A copy was made"
  ```
  - copy 1: return to a temp
  - copy 2: from temp to object








## Rvalue References



### Lifetime



### Non-const References



**Reads**

- [Returning R-val-references](https://stackoverflow.com/questions/4986673/how-to-return-an-object-from-a-function-considering-c11-rvalues-and-move-seman/4986802#4986802)

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







## Move Semantics for Custom Data Structures

In general you have to implement:
1) Copy ctor
2) Move ctor
3) Copy assignment operator
4) Move assignment operator
5) Destructor

```cpp
Foo (vector<int> vec) : _member{std::move(vec)} {}
```

### Standard

> If the class definition does not explicitly declare a copy constructor, one is declared *implicitly*. **If the class definition declares a move constructor or move assignment operator, the implicitly declared copy constructor is defined as deleted**; otherwise, it is defined as defaulted. The latter case is deprecated if the class has a user-declared copy assignment operator or a user-declared destructor. Thus, for the class definition
>
> ```
> struct X {
>     X(const X&, int);
> };
> ```
>
> a copy constructor is implicitly-declared. If the user-declared constructor is later defined as
>
> ```
> X::X(const X& x, int i =0) { /* ... */ }
> ```
>
> then any use of X’s copy constructor is ill-formed because of the ambiguity; no diagnostic is required.



### Implicit Generation of Move Semantics

Only generated if:

- no user-declared copy constructor
- no user-declared copy assignement operator
- no user-declared move assignment operator
- no user-declared destructur **and** no explicitly `deleted` move constructor

```cpp
class Lifetime {
public:
  Lifetime() { std::cout << "Constructor" << std::endl; }
  Lifetime(const Lifetime &other) {
    std::cout << "Copy Constructor" << std::endl;
  }
};
```

```cpp
Lifetime temp;
Lifetime x = std::move(temp);
```

**Output**:

```cpp
Constructor
Copy Constructor
```





### Implementations

**Invocation**

```cpp
    A c(5); // ctor
    A cc(std::move(c)); // move ctor
```

**Auto Generated Move Constructors**

```cpp
struct Data {
    int a, b, c;
    int* ptr;
    // compiler provided copy ctor does this:
    Data(const Data& rhs)
        : a(rhs.a)
        , b(rhs.b)
        , c(rhs.b)
        , ptr(rhs.ptr)
    {}
    
    // whereas the compiler provided move ctor does this:
    Data(Data&& rhs)
        : a( std::move(rhs.a) )
        , b( std::move(rhs.b) )
        , c( std::move(rhs.c) )
        , ptr( std::move(rhs.ptr) )
    {}
};
```

**Static Array Move Constructor**

```cpp
class Data
{
    int a, b, c;
    int* array;
public:
    Data() : a(), b(), c()
    {
        array = new int[200];       // this object allocates and owns this buffer
    } 
    
    Data(const Data& d) :
        a(d.a), 
        b(d.b),
        c(d.c)
    {
        array = new int[200];                   // this object allocates and owns this buffer
        std::copy(d.array, d.array+200, array); // <- copy data for that buffer from 'd's buffer
    } 
    Data(Data&& d) : 
        a(std::move(d.a)),      // the std::moves here aren't really necessary (basic types)
        b(std::move(d.b)),
        c(std::move(d.c))
    {
        array = d.array;        // we are not allocating an buffer, but are merely taking ownership of 'd's buffer
        d.array = nullptr;      // <- have 'd' release it so that it no longer owns it.
    } 
    
    // destructor
    ~Data() {
        // delete whatever array we own
        delete[] array;
    }
    
    // copy assignment
    Data& operator = (const Data& d) {
        // no need to reallocate, because this object already owns a buffer.  Simply copy
        //   the data over
        a = d.a;
        b = d.b;
        c = d.c;
        std::copy(d.array, d.array+200, array);
        
        return *this;
    }
    
    // move assignment
    Data& operator = (Data&& d) {
        // no need to reallocate -- or even to copy.  We just want to move ownership of d's buffer
        //   to this object.
        a = d.a;
        b = d.b;
        c = d.c;
        
        delete[] array;     // unallocate the buffer we currently own
        array = d.array;    // take ownership of d's buffer
        d.array = nullptr;  // have d release ownership of the buffer
        
        return *this;
    }
};
```

```cpp
class Resource {
public:
Resource& operator=(Resource&& other) {
    if (this != &other) {           // If the object isn't being called on itself
        delete this->data;          // Delete the object's data
        this->data = other.data;    // "Move" other's data into the current object
        other.data = nullptr;       // Mark the other object as "empty"
    }
    return *this;                   // return *this
}
void* data;
};
```

**Move Operations on Derived Classes**

```cpp
class Shader {
  public:
    // custom move assignment
    Shader& operator=(Shader&& other) { ... }
}

class VertexShader : public Shader {
  public:
    // move ctor
    explicit VertexShader(VertexShader &&other) : Shader(std::move(other)) {}
    // move assignment
  	VertexShader& operator=(VertexShader&& other) { 
        // call move assignment operator of parent class
        Shader::operator=(std::move(rhs));
        return *this;
    }
}
```



## std::reference_wrapper





## Examples





#### Moving a Class Member

- `std::move(object).member` safe - "a member of an rvalue"
- `std::move(object.member)`





