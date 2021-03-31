# Perfect Forwarding

- Introduced in C++11 through use of rvalue references `&&`
- allows function template to **pass its argument through to another function** while retaining the original lvalue/rvalue nature of the function arguments
  - avoids unnecessary copy and duplicate method overloads





## Definition of Argument Forwarding

- use `std::forward` to pass arguments to next method

```cpp

class Blobb {
  public:
  // data storage
  std::vector<std::string> v_;
  
  template<typename... Args>
  Blobb(Args&&... args): v_(std::forward<Args>(args)...){}
}
```







## Construction with Forwarding

- see https://www.fluentcpp.com/2018/12/11/overview-of-std-map-insertion-emplacement-methods-in-cpp17/





### C++11: Move Semantics and In-place construction

- `C++11` introduced `emplace` : same functionality as `insert` but with **in-place construction**





**Explicit Inplace Construction**

- sometimes copy is more efficient than move (big structures)
- `std::forward_as_tuple` constructs a tuple of references to the arguments in `args` suitable for forwarding as an argument to a function.



### C++17: try_emplace, insert_or_assign

