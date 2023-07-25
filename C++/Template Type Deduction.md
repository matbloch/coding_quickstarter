# Template Type Deduction











### Map key/value types

```cpp
template <typename Container,
          typename ValueType = typename Container::mapped_type,
          typename KeyType = typename Container::key_type>
std::optional<ValueType> getValueOrNull(Container const &map_data, KeyType const &key) {
    auto const iter = map_data.find(key);
    if (iter != map_data.end()) {
        return iter->second;
    }
    return std::nullopt;
}
```







### Lambda type

- `decltype(LAMBDA())`
- `decltype` is useful when declaring types that are difficult or impossible to declare using standard notation, like lambda-related types or types that depend on template parameters.

```cpp
template <typename Lambda>
auto myFunc(Lambda f) {
  using ReturnType = decltype(f());
  ReturnType result = f();
  //...
  return result;
}
```

