# Initialization in C++



https://blog.tartanllama.xyz/initialization-is-bonkers/

http://mikelui.io/2019/01/03/seriously-bonkers.html





## Struct and union initialization

https://en.cppreference.com/w/c/language/struct_initialization

```cpp
struct MyStruct {
  MyStruct() = default;
  int a = 2;
}
```

**const static structure**

- set at compile time

```cpp
// Header file
class Game {
    public:
        // Declaration:
        static const struct timespec UPDATE_TIMEOUT;
    ...
};

// Source file
const struct timespec Game::UPDATE_TIMEOUT = { 10 , 10 };  // Definition
```



- A static variable of a base class is a common variable for all classes including the base and its derived classes. 