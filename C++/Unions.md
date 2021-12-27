# Unions

- source: https://www.modernescpp.com/index.php/c-core-guidelines-rules-for-unions



### Declaration

```cpp
union MyUnion {
    std::string str;
    std::vector<int> vec;
}
```



### Allocation

- The union is only as big as necessary to hold its largest data member. 
- The other data members are allocated in the same bytes as part of that largest member
- Can hold only one type at one point at a time



### Writing & Reader Members



```cpp
MyUnion s = "test";
// at this point, reading from "s.vec" is undefined behavior
```

```cpp
union Value {
  int i;
  double d;
}

Value v = {123};	// holds an int
v.d = 9844.265;   // now holds a double

```



### Saver Option: `std::variant`



