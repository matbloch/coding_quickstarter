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





## Class Initialization



**Initialization Order**

1. `virtual` base classes
2. direct base classes (depth-first)
3. nonstatic data members, in order of declaration in the class definition
   - also applies to initializer list
4. body of constructor





### Initialization Types

##### Method 1: Class constructor

##### Method 2: Initialization list

- initializer list just specifies values and base class constructors
  - order of initialization not changed
  - order of initialiser list should be canonical to prevent reading from uninitialized memory
- If a member class does not have a default constructor: It **MUST** be initialized wth an initialization list

##### Method 3: Assignment



#### Pitfalls

```cpp
class A : public B {
  public:
  // base classes are initialized before members - "a_member" is not initialized
  A(): B(a_member), a_member(123) {}
  int a_member;
}
```



