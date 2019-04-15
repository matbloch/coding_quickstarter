# C++ 11 Move Semantics



## Default Containers

**vector**

- vector will be empty after move

`A = std::move(B);`



## Custom Data Structures

In general you have to implement:
1) Copy ctor
2) Move ctor
3) Copy assignment operator
4) Move assignment operator
5) Destructor

```cpp
Foo (vector<int> vec) : _member{std::move(vec)} {}
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
        a(std::move(d.a)),      // the std::moves here aren't really necessary because they are basic types.
        b(std::move(d.b)),      //  but whatever.
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



