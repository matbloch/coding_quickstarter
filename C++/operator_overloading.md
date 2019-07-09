# Overloaded Operators



Guide: https://en.cppreference.com/w/cpp/language/operators

Topics:

- Definition inside/outside class







## Comparison

```cpp
bool operator==(Contact& other) const {
//compare all elements, one by one...
}
```



## Assignment

```cpp
MyClass& MyClass::operator=( const MyClass& other ) {
  x = other.x;
  return *this;
}
```

**Special Cases**

- `const` member: make private, add `getter`

### Examples

**zero-copy sub-matrix**





## Arithmetics





