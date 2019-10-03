# C++ Design Patterns

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







## 3. Behavioral Patterns



### Strategy Pattern





### State Machine