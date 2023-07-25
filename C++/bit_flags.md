# Bit Flags



## Declaration

### 01. Plain Enums

```cpp
enum State
{
  minimizing = 0x01, // 00000001
  maximizing = 0x02, // 00000010
  minimized  = 0x04, // 00000100
  maximized  = 0x08  // 00001000
};
// or
enum State {
    MINIMIZING = (1u << 0),
    MAXIMIZING = (1u << 1),
    MINIMIZED  = (1u << 2),
    MAXIMIZED  = (1u << 3),
};

unsigned int myState = 0;

myState |= MAXIMIZED;  // sets that bit
myState &= ~MAXIMIZED; // resets that bit

```

**Operations**

- Set: `set |= a`
- Clear/reset: `set &= ~a`
- Toggle: `set ^= a`
- Check bit: `(set & a) != 0`

**Comparison**

Then, you can combine multiple values with bitwise or (minimizing | maximized) and test for values with bitwise and (bool is_minimized = (flags & minimized);).



### 02. Using Class Enums

- class enums are scoped but cannot be converted to other types implicitly
- Need overload for operations

```cpp
flags operator~(const flags& f) {
    return flags(~static_cast<int>(f));
}

flags operator|(const flags& a, const flags& b) {
    return flags(static_cast<int>(a) | static_cast<flags>(b));
}
...
```



## Guidelines

**use class enums**
```cpp
enum class StatusFlag {
    UNKNOWN = 0,
    SUCCESS = 1,
    NO_NETWORK_CONNECTION = 2
};
```

