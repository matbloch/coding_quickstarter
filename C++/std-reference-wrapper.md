# std::reference_wrapper

> used as a mechanism to store references inside **standard** containers (like **std::**vector) which cannot normally hold references.



- syntax: `std::reference_wrapper<T>`

```cpp
class MyClass {
public:
    MyClass& operator=(MyClass const& other){}
private:
    T& reference;
};
```

What should `operator=` do? The natural thing would be to make `reference` point to the same object as `other.reference` does,
but references can’t rebind. For this reason, the compiler gives up and
doesn’t implement a default assignment operator in this case.



```
T object1;
auto reference = std::ref(object1); // reference is of type std::reference_wrapper<T>
T object2;
reference = std::ref(object2); // reference now points to object2
// object 1 hasn't changed
```

Returning references instead of pointers: make it clear that caller is not responsible for lifetime management:

```cpp
std::vector<std::reference_wrapper<Foo>> Bar::getFoos() const {
  std::vector<std::reference_wrapper<Foo>> fooRefs;
  for (auto &ptr : foos) {
    fooRefs.push_back(std::ref(*ptr));
  }
  return fooRefs;
}
```

