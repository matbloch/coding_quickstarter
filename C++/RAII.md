# RAII - Resource Acquisition is Initialization

> Programming technique to bind lifecycle of a resource that must be acquired before use.
>
> Also known as: Scope Bound Resource Management (SBRM)



**Goals**

- guarantee that resource is released when lifetime of their controlling objects end



**Principles**

- **encapsulcate** each resource into a class where
  - constructor acquires the resource
  - destructor releases the resource
- always use resource **via RAII-class** that
  - has automatic storage duration or temporary lifetime itself, or
  - has lifetime that is bounded by the lifetime of an automatic/temporary object



**Applications**

- multi-threading (locks)
- memory management
- Open file

### Example: Mutex Locking

**Bad example**

```cpp
std::mutex m; 
void bad() {
    m.lock();                    // acquire the mutex
    f();                         // if f() throws an exception, the mutex is never released
    if(!everything_ok()) return; // early return, the mutex is never released
    m.unlock();                  // if bad() reaches this statement, the mutex is released
}
```

**Good example**

```cpp
std::mutex m;
void good() {
    std::lock_guard<std::mutex> lk(m); // RAII class: mutex acquisition is initialization
    f();                               // if f() throws an exception, the mutex is released
    if(!everything_ok()) return;       // early return, the mutex is released
}                                      // if good() returns normally, the mutex is released
```

