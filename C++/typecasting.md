# Typecasting



## Run-time Type Information (RTTI)

- Feature of C++ to expose information about an object's data type at runtime.

- can be used to do safe typecasts, using `dynamic_cast<>`
- optional, can be enabled at compile time



## Type Casting

C++ supports 4 types of casting operators:



1. **`static_cast`**

- preferred over c-style casting
- more restrictive and hence safer

`double result = static_cast<double>(4)/5;`

2. **`dynamic_cast`**

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

### Examples



## Virtual Tables in C++

https://pabloariasal.github.io/2017/06/10/understanding-virtual-tables/



For each concrete implementation of class:

- Table of function pointers to all the virutal methods
- pointer to this table exists as data member in all the objects
- when virtual method is called, appropriate derived class method is looked up in the v-table



## Up- and Downcasting

**Memory Layout**



### Up-Casting

- cast derived as base class



### Down-Casting

- Should be avoided in general, sign of bad design
- use `dynamic_cast` to check that casting is safe

```cpp
Base* pBase = new Derived;
Derived* pDerived = dynamic_cast<Derived*>(pBase);
if (pDerived) {
  // successful cast
} else {
  // fail to down-cast
}
```



### Casting of Smart Pointers

```cpp
struct A {}
struct B : A {}
// potentially incomplete object
auto foo = std::make_shared<A>();
std::shared_ptr<B> bar = std::static_pointer_cast<B>(foo);
```

