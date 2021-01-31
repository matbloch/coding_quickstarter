# Macros

> Scripted directives for the compiler (compile-time logic)



**Excution order**

1. Source Code
2. Preprocessor: Substitute and execute directives (begin with `#`)
3. Compiler
4. Assembler: Translate into machine code
5. Linker: Convert one or more binary objects into executables
6. Executable



## Directives

**#include**

- will be substituted with functions

```cpp
#include <iostream>
```





## Predefined Macros

- `__FILE__`
- `__LINE__`
- `__DATE__`
- `__FUNCTION__` name of the current function as it appears in source



## Macros

- no whitespace between argument and parenthesis
- No typechecking!

```cpp
#define MAX(a,b) (a > b ? a : b)
```



### Examples



**Pass Scope**



**Variable Arguments**

- `__VA_ARGS__` used to insert extra arguments

Definition:

```cpp
#define CHECK1(x, ...) if (!(x)) { printf(__VA_ARGS__); }
#define CHECK2(x, ...) if ((x)) { printf(__VA_ARGS__); }
#define CHECK3(...) { printf(__VA_ARGS__); }
#define MACRO(s, ...) printf(s, __VA_ARGS__)
```

Usage:

```cpp
CHECK1(0, "here %s %s %s", "are", "some", "varargs1(1)\n");
CHECK1(1, "here %s %s %s", "are", "some", "varargs1(2)\n");   // won't print
CHECK2(0, "here %s %s %s", "are", "some", "varargs2(3)\n");   // won't print
CHECK2(1, "here %s %s %s", "are", "some", "varargs2(4)\n");
CHECK3("here %s %s %s", "are", "some", "varargs3(5)\n");
MACRO("hello, world\n");
```

