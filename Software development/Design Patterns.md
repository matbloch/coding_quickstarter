# Software Design Patterns

- [Excellent list, summarize this!](https://sourcemaking.com/design_patterns)
- https://www.youtube.com/watch?v=motLOioLJfg&feature=youtu.be



**Classification of Patterns**

- **Creational patterns** provide object creation mechanisms that increase flexibility and reuse of existing code.
- **Structural patterns** explain how to assemble objects and classes into larger structures, while keeping the structures flexible and efficient.
- **Behavioral patterns** take care of effective communication and the assignment of responsibilities between objects.





## 1. Creational Patterns

- Factory
- Singleton
- Object Pool





#### Resource Pooling

**Performance Gains:**

- You have already pre-allocated all the objects in one big block, 
  allocating objects from the pool thus bypasses new/delete (or 
  malloc/free) and the risk of page allocations and all that fun stuff as 
  we have already forced the page allocations on initialisation of the 
  object pool. Hence allocation and de-allocation is typically faster but 
  more importantly more consistent in time.
- All the objects are contiguous in memory. This reduces memory 
  fragmentation and improves cache coherency somewhat if you access the 
  objects frequently.

#### Singleton

- Class with a single instance and global access

- Usually deprecated since it's a sign of bad design

- Alternatives:

  - Dependency injection
  - Monostate pattern
  - Session context


![singleton-schema.png](img\singleton-schema.png)



**C++ 11 Implementation:**

```java

```





## 2. Structural Patterns

#### Proxy Wrapper 

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



**Proxy-Calling: ** Non-static member function pointers

```cpp
template <typename F>
void forwardCall(F &&process) {
    for (const auto &o : pool_) {
        process(member_);
    }
}
```



### Trait Classes

….



### PIMPL Pattern

Pointer to Implementation

- Remove compilation dependencies on internal class implementations and improve compile times.



Foo.h

```cpp
 class foo {   
   public:     
   foo();     
   ~foo();     
   foo(foo&&);     
   foo& operator=(foo&&);   
   private:     
   class impl;     
   std::unique_ptr<impl> pimpl; 
 };
```

foo.cpp

```cpp
// foo.cpp - implementation file 
class foo::impl {   
  public:     
  void do_internal_work()     {       
    internal_data = 5;     
  }   
  private:     
  int internal_data = 0; 
}; 
foo::foo(): pimpl{std::make_unique<impl>()} {   
  pimpl->do_internal_work(); 
} 
```



#### Dependency Injection

```cpp
class MyClass {
  public:
  MyClass(std::function custom_func): functor(custom_func) {}
  std::function functor;
}
```









### Variable data containers

Options:

1. use `std::variant` return type
2. Use `dynamic_cast`
   - requires virtual inheritance > all access through pointer/heap, through v-table





```cpp
struct MyVariant {
  std::variant<int, std::string, float> data_;
}
```







## 3. Behavioral Patterns



### Strategy Pattern





### State Machine





### Observer



### Views

- prevents copies of expensive data

```cpp
template<typename K, typename V>
class MapView {
public:
    using MapType = std::map<K, V>;
    using KeyVector = std::vector<K>;
    using IteratorVector = std::vector<typename MapType::const_iterator>;
    MapView(const MapType& map, const KeyVector& keys) {
        for (const auto& key : keys) {
            auto it = map.find(key);
            if (it != map.end()) {
                iterators.push_back(it);
            }
        }
    }
    typename IteratorVector::const_iterator begin() const {
        return iterators.begin();
    }
    typename IteratorVector::const_iterator end() const {
        return iterators.end();
    }
private:
    IteratorVector iterators;
};
```





## Consumption of different types

> How to you design interfaces that should be able to consume different types?





### Language: C++

#### Opt 1: Virtual Inheritance

- indirect lookup through V-table: Memory fragmentation

- doesn't force you to implement algorithms for new overloads



#### Opt 2: Implement just the interface

- compile-time checks



#### Opt 3: std::variant

- duplicate space (combination of all variants)
- tedious to write all supported types
- no shortcut to specify that the type doesn't play a role



#### Opt 4: Templates

- lot of boiler-plate



#### Opt 5:  Concepts (C++20)

- 



### Language: ...



#### Opt 1: Protocol







### 





## Other



### Non-Virtual Inheritance Pattern





### Testing Private Members



