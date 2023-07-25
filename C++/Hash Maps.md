# Hash Maps

> C++ unordered containers (e.g. `unordered_map`, `unordered_set`, etc.) uses “hashing” to store objects. STL provides hash functions for common types but we can also use a custom hash implementation.





## Hash Combination

See also http://myeyesareblind.com/2017/02/06/Combine-hash-values/ for an extensive list



### 01. XOR (bad)

**Idea:** Combine existing functions using exclusive-or/XOR (`^`)

```c++
hash(first) ^ hash(second); 
```

**Explanation**

- Assuming uniformly random (1-bit) inputs, the AND function output probability distribution is 75% `0` and 25% `1`. Conversely, OR is 25% `0` and 75% `1`.
- The XOR function is 50% `0` and 50% `1`, therefore it is good for combining uniform probability distributions.

**Problems**

- Pair-wise identical values are mapped to `0` (e.g. `(a,a)`). In real life, these are more common.
- `xor` is symmetric: Order of elements gets lost



### 02. Shifted AND

**Idea:** Shift the bits of each property to a different position

```cpp
(hash(first) << 8) | hash(second)
```

**Explanation**

- all properties map to a different bit range and are distinct



## Custom Hashes with `std`

- **NOTE**: Unordered containers, such as `std::unorderd_set` and `std::unordered_map` also need the equality operator `operator==()`  to be implemented for the key type. 
- Lookup: Find `std::hash(search_value)` in the map (logical `==`)



### 01. Overload `std::hash`

- overload `()` operator on `std::hash`

```cpp
struct MyCustomType {
  // ...
}

template <>
struct std::hash<MyCustomType> {
    size_t operator()(MyCustomType const &type) const noexcept {
      // calculate the hash  
      return my_hash;
    }
};

// usage
std::unordered_set<MyCustomType> set;

MyCustomType example_key;
auto hash = std::hash<MyCustomType>()(example_key);
```

### 02. Hash Struct

- define struct with hash returned through `()` operator

```cpp

// a.) define generically
struct PairHash {
  template <typename T1, typename T2>
  auto operator()(const pair<T1, T2> &p) const -> size_t {
    return hash<T1>{}(p.first) ^ hash<T2>{}(p.second);
  }
};

// b.) define for the key type specifically
struct CustomKey {
    int value;
    std::size_t operator()(const CustomKey& key) const {
        return std::hash<int>{}(key.value);
    }
};

// usage
std::unordered_set<pair<string, int>, PairHash> set;
```



## Custom Hash Comparison with `std`

NOTE:

- `std` does not expose way to search for multiple matches

```cpp
struct CustomKeyHash {
    std::size_t operator()(const CustomKey& key) const {
        return // ...
    }
};
// Custom hash function to perform bitwise AND on keys
struct CustomKeyEqual {
    bool operator()(const CustomKey& a, const CustomKey& b) const {
        return a.value & b.value;
    }
};
```









## Partial Hash Lookup



