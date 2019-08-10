# Typecasting



## Run-time Type Information (RTTI)

- Feature of C++ to expose information about an object's data type at runtime.

- can be used to do safe typecasts, using `dynamic_cast<>`
- optional, can be enabled at compile time



## Type Casting

### C-style Casts

- not checked at runtime

```cpp
Parent parent;
Child child;
// upcast - implicit type cast allowed
Parent *pParent = &child;
// downcast - explicit type case required 
Child *pChild =  (Child *) &parent;
```

### C++ Casts

- checked at runtime
- make intend of developer more clear

C++ supports 4 types of casting operators:

1. **`static_cast`**

- preferred over c-style casting
- more restrictive and hence safer

`double result = static_cast<double>(4)/5;`

2. **`dynamic_cast`**

- requires Run-time type information (RTTI)
- returns `NULL` if fails: allows to check success (if not a reference)

`<type> *p_subclass = dynamic_cast<<type> *>( p_obj );`

`<type> subclass = dynamic_cast<<type> &>( ref_obj );`

3. **`const_cast`**

- used to cast away `const`
- should only be used sparingly

`const_cast<<type>>(<value>);`

4. **`reinterpret_cast`**

- Least safe cast
- interprets underlying bits
- should **NOT** be used to cast down class hierarchy or to remove `const` qualifiers

`reinterpret_cast<int *>(100);`

#### Examples



## Virtual Tables in C++

https://pabloariasal.github.io/2017/06/10/understanding-virtual-tables/

For each concrete implementation of class:

- Table of function pointers to all the virtual methods
- pointer to this table exists as data member in all the objects
- when virtual method is called, appropriate derived class method is looked up in the v-table



## Up- and Downcasting

**Memory Layout**



### Up-Casting (derived > base)





--------------

### Down-Casting (base > derived)

- Should be avoided in general, sign of bad design

#### A. Dynamic Cast

- uses runtime type information (requires it to be enabled) to check if cast is save:

  > Run-time type information (RTTI) is a feature of C++ that exposes 
  > information about an object’s data type at runtime.  This capability is 
  > leveraged by dynamic_cast.  Because RTTI has a pretty significant space 
  > performance cost, some compilers allow you to turn RTTI off as an 
  > optimization.  Needless to say, if you do this, dynamic_cast won’t 
  > function correctly.

- **can fail**

- `dynamic_cast` will **not** work for:

  - Private/protected inheritance
  - For classes that have no virtual method (declared or inherited): *There is no virtual table*

```cpp
Base* pBase = new Derived;
Derived* pDerived = dynamic_cast<Derived*>(pBase);
if (pDerived) {
  // successful cast
} else {
  // fail to down-cast
}
```

**Casting Failure**

- result is nullptr on failure

#### B. Static Cast

- no runtime type checking

-----------

### Casting of Smart Pointers

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

