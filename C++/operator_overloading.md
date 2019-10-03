# Overloaded Operators



Guide: https://en.cppreference.com/w/cpp/language/operators

Topics:

- Definition inside/outside class







**Relational Operators**

- Algorithms like `std::sort` expect `operator<` to be defined

```cpp
inline bool operator< (const X& lhs, const X& rhs){ /* do actual comparison */ }
inline bool operator> (const X& lhs, const X& rhs){ return rhs < lhs; }

// or in class:
struct Record
{
	double weight;
    friend bool operator<(const Record& l, const Record& r){
    	return l.weight < r.weight;
    }
}

```





### Comparison

```cpp
bool operator==(Contact& other) const {
//compare all elements, one by one...
}
```

### Assignment

```cpp
MyClass& MyClass::operator=( const MyClass& other ) {
  x = other.x;
  return *this;
}
```

**Special Cases**

- `const` member: make private, add `getter`

### Implicit Conversion

```cpp
TODO
```



### Examples

**zero-copy sub-matrix**





## Arithmetics





