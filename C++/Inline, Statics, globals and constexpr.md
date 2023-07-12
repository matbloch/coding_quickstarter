# Inline, Statics, globals and constexpr



## 00. Inline





**`inline`** variables (C++17)

> A variable declared inline has the same semantics as a function declared inline: it can be defined, identically, in multiple translation units, must be defined in every translation unit in which it is used, and the behavior of the program is as if there was exactly one variable.

```cpp
struct MyClass {
    static const int sValue;
};
inline int const MyClass::sValue = 777;
```

or 

```cpp
struct MyClass {
    inline static const int sValue = 777;
};
```









## 01. Static variables

- must be initialized before the program starts
- has to be thread-safe
- initialization order is undefined



TO READ: https://pabloariasal.github.io/2020/01/02/static-variable-initialization/



### Initialization

1. Inline

   - only possible for integral/enum types

   ```c++
   static int myVariable = 42;
   ```

2. Outside definition (inside a .cpp file)

   ```cpp
   int MyClass::myVariable = 42;
   ```

3. Next to definition

   **NOTE:** use `inline` variable definition to avoid duplicate symbols on includes.

   ```cpp
   class MyClass {
   public:
       static int myVariable;
   };
   inline int MyClass::myVariable = 42;
   ```

4. constexpr (>= C++11)

   ```cpp
   class MyClass {
   public:
       static constexpr int myVariable = 42;
   };
   ```



### Examples



```cpp
struct Settings {
  struct SubSettings {
    int a = 123;
  }
  static const SubSettings kSub;
};

inline Settings::SubSettings const Settings::kSub = {};
```







## 02. constexpr

> `constexpr` specifies that the value of an object or a function can be  **evaluated at compile time** and the expression can be used in other  constant expressions. 



**constexpr vs inline functions:**

- **inline**: expanded at compile time, save time of function call overhead (allways evaluated at run time)
- **Constexpr**: evaluated at compile time





### static constexpr

- https://stackoverflow.com/questions/14116003/difference-between-constexpr-and-const

- `static`
  - must be initialized before the program starts
  - has to be thread-safe
  - initialization order is undefined
- `constexpr` 
  - forces constant compile-time initialisation
  - all other static variables are zero initialized
  - shouldn't have non-trivial destructior (e.g. freeing of memory). e.g. for `std::string`



**example:** std::string

(only possible as of C++17)

```cpp
static constexpr std::string my_string = "abc";
```

Instead do:

```cpp
constexpr char constString[] = "constString";
```







### Limitations

**C++11**

1. In C++ 11, a constexpr function should contain only one return statement. C++ 14 allows more than one statements.

2. constexpr function should refer only constant global variables.

3. constexpr function can call only other constexpr function not simple function.

4. Function should not be of void type and some operator like prefix increment (++v) are not allowed in constexpr function.



#### std::string



#### Values used in constructors / passed along by reference

- use ENUM instead

