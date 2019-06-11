# Typecasting



## Run-time Type Information (RTTI)

- Feature of C++ to expose information about an object's data type at runtime.

- can be used to do safe typecases, using `dynamic_cast<>`
- optional, can be enabled at compile time



## Type Casting

**Static Casting**

- preferred over c-style casting
- more restrictive and hence safer

`double result = static_cast<double>(4)/5;`

**Dynamic Casting**

- returns `NULL` if fails: allows to check success (if not a reference)

`<type> *p_subclass = dynamic_cast<<type> *>( p_obj );`

`<type> subclass = dynamic_cast<<type> &>( ref_obj );`

**Const Casting**

- used to cast away `const`
- should only be used sparingly

`const_cast<<type>>(<value>);`

**Reinterpret-Cast**

- Least safe cast
- interprets underlying bits
- should NOT be used to cast down class hierarchy or to remove `const` qualifiers

`reinterpret_cast<int *>(100);`



### Examples





