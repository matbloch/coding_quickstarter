# C++ 11 Move Semantics



## Default Containers

**vector**

- vector will be empty after move

`A = std::move(B);`



## Rvalue References

**Reads**

- [Returning R-val-references](https://stackoverflow.com/questions/4986673/how-to-return-an-object-from-a-function-considering-c11-rvalues-and-move-seman/4986802#4986802)

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

