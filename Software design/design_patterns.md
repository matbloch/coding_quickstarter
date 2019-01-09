# Software Design Patterns



## Singleton

- Class with a single instance and global access

- Usually deprecated since it's a sign of bad design

- Alternatives:

  - Dependency injection
  - Monostate pattern
  - Session context


![singleton-schema.png](img\singleton-schema.png)



**C++ Implementation:**

```java

```



**Double-checked locking pattern**

```cpp

```





## Monostate Pattern



## Dependency Injection





## Resource Pooling



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





