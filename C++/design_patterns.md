# C++ Design Patterns

- [Excellent list, summarize this!](https://sourcemaking.com/design_patterns)





### Inheritance vs Composition



## 1. Creational Patterns

- Factory
- Singleton
- Object Pool



## 2. Structural Patterns

### Proxy Wrapper 

- Protect members, restrict access to wrapper

```cpp
template <class ObjectType>
struct Wrapper {
	Wrapper(ObjectType &object): object_(object) {}
    ObjectType* operator->() const {
    	return &object_;
    }
    private:
    	ObjectType& object_;
}

struct Resource {
	int a = 123;
	int b = 123;
}

Resource res;
auto wrapper = Wrapper<Resource>(res);
wrapper->a = 345;
wrapper->b = 345;
```

### Trait Classes

….



## 3. Behavioral Patterns



### Strategy Pattern





### State Machine