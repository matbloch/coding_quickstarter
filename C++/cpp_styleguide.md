# Coding Styleguide and Best Practice for C++

**Guidelines**: https://isocpp.github.io/CppCoreGuidelines/CppCoreGuidelines#c2-use-class-if-the-class-has-an-invariant-use-struct-if-the-data-members-can-vary-independently





## Naming

- Use `snake_case` for variables
- Use `snake_case` for simple accessors (setter and getters)
- Use `camelCase` for methods
- Use `CamelCase` for classes
- Use `snake_case_` for member variables.
- Use `snake_case` for functions in anonymous space
- Class enums: Use `CamelCase` for enum names, `UPPER_SNAKE_CASE` for enum values

## General

- as many variables `const` as possible
- pass arguments: `const &`
- use `std::move()` to copy data into output containers
- prevent default method arguments when not often changed. Use class property instead
- Always use `nullptr` for initializing null pointers.
- use range based for loop, when iterating vectors
```cpp
for (const auto &data_block : dataBlocks) {}
```
- use `const T&` istead of `T const&`
- for "direct" header files use `#include "MyClass.h"` instead of `<...>`
- Use upper case for type declarations, e.g. `using ReturnType = ...`

## Control Flow

- Prefer early exit of nested if statements

## OOP

**private static vs private const**

- use `private static`, if the method does not belong to an instance of the object

**`virtual` Destructors**

- add `virtual` keyword to destructor to prevent memory leak for child data containers (correct destructor, pointer type, is looked up at code execution time in object known as *vtable*)
- When a base class destructor is declared virtual then the destructor of the actual class pointed to by a base class pointer `bp` is going to be called when `delete bp` is executed.

```cpp
void do_something() {
 Base* p = new Derived;
 // Derived destructor not called!!
 delete p;  
}
```

instead:

```cpp
class Base {
public:
 virtual ~Base();
};

class Derived : public Base {
 virtual ~Derived();
}
```

**`explicite` Constructors**

- add `explicite` to ctors with single argument to avoid implicite conversion, e.g. `A a = 1`

**Member Variables**

- if getter and setter: just use public variable

**Member Initialization**

- ***member-initializer-list***: follows rules of *direct-initialization* - 

  - no temporaries are moved/copied
  - **explicit** context (no implicit conversion)

  ```cpp
  X::X(int) : i{22}{}
  ```

- ***brace-or-equal-initializer***:

  - guaranteed default, also if multiple contours are present

  ```cpp
  class X {
    int i = 4;
    int j {5};
  };
  ```

  

## Misc

### constness

- [Article const correctness](https://yosefk.com/c++fqa/const.html)

**const reference vs reference to const**

- `const T&` and `T const&` are the same, matter of style
- use `Fred const &arg` for consistency with right-left rule about parsing

**const static vs static const**
- `const`, `static` is ordered
- but `static` should be put at the beginning (C convention)
- e.g. `static const int`

**const ptr vs ptr to const**
```cpp
Mode const * mode = nullptr;
// or:
const Mode * mode = nullptr;
// is not the same as
Mode * const mode = nullptr;
```

**ptr vs reference members**
- use reference if assigned once at construction
- otherwise use ptrs

**Mutable/Mutex**
- use `mutable` instead of const for member, if const member functions need to modify the variable but for the user (public methods), the object still is the same

**Pointer casting**

- use `dynamic_cast` to cast from base to derived class

### Random

**order of declarations**
- [clockwise/spiral rule](http://c-faq.com/decl/spiral.anderson.html)
```cpp
int const * - pointer to const int
int * const - const pointer to int
```


**inline functions**
- `inline` obsolete if function body defined in header file. Copiler marks as inline

**Include style**
- `#include "path-spec"` look for file in same directory
- `#include <path-spec>` search in path

**`cmath` vs `math.h`**
- use `<cmath>`, defines function in `std::` namespace

**preventing operations**
- prevente copying: delete the copy-assignment and copy-constructor operators

**`std::move`**
- use `std::move` whenever you copy containers
- indicate that an object t may be "moved from", i.e. allowing the efficient transfer of resources from t to another object.
- This allows for certain optimizations if the client is passing rvalue arguments.

**enums**
```cpp
enum class Color { red, green, blue }; // enum class
enum Animal { dog, cat, bird, human }; // plain enum

Color my_color = Color::red;	// scoped
Animal my_animal = dog;				// NOT scoped
```
- **enum classes**: + scoped, - cannot be converted to integer/others (e.g. for bit flags)
- **Plain enums** - not scoped, + implicitly convert to integers

**shared pointers**

- Shared pointers usually have a somewhat large penalty when being copied and deallocated.

**Lambas**

- If nothing captured: use free function

-----------

## Efficient Coding

- [Article to read](https://www.geeksforgeeks.org/writing-cc-code-efficiently-in-competitive-programming/)

### Efficient Returns

**No modification of return**
- bind return to const reference
- no copy needed
```cpp
const std::vector<A>& b = MyFunc();
```

### Efficient Argument Passing


```cpp
void f (const std::string& s)	// lvalue -> copy
{
  std::string s1 (s); // copy
  ...
}
void f (std::string&& s)	// rvalue -> move
{
  std::string s1 (std::move (s)); // move
  ...
}
```

