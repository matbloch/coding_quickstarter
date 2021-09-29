# Software Design Patterns

- [Excellent list, summarize this!](https://sourcemaking.com/design_patterns)



### Inheritance vs Composition

**Composition**

- implementation hidden (header files not exposed)
- classes can be switched at runtime
- methods need to be forwarded

**Inheritance**

- no code duplication for forwarding
- headers exposed
- class switch only at compile time





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



### Trait Classes

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



## 3. Behavioral Patterns



### Strategy Pattern





### State Machine



