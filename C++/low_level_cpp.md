# Low-Level C++ and Computer Architecture



**Reads to summarise**

- 

**Topics**

- RAII
- Stack/heap, allocation/cleanup
- cache miss
- branching
- memory layouts
- ...







## Resource Management

[Summary](https://docs.microsoft.com/en-us/cpp/cpp/object-lifetime-and-resource-management-modern-cpp?view=vs-2017)

**Topics**

- Stack/heap, allocation/deallocation

- Pointer/references (pointer size etc)




### Memory Allocation

```cpp
YourClass foo;
Rectangle rect (3,4);	// constructor with arguments

// Method 1
Foobar *foobar = new Foobar();
delete foobar; // TODO: Move this to the right place.

```

- Method 1 (using new)
  - Allocates memory for the object on the free store (This is frequently the same thing as the heap)
  - Requires you to explicitly delete your object later. (If you don't delete it, you could create a memory leak)
  - Memory stays allocated until you delete it. (i.e. you could return an object that you created using new)
  - The example in the question will leak memory unless the pointer is deleted; and it should always be deleted, regardless of which control path is taken, or if exceptions are thrown.
- Method 2 (not using new)
  - Allocates memory for the object on the stack (where all local variables go) There is generally less memory available for the stack; if you allocate too many objects, you risk stack overflow.
  - You won't need to delete it later.
  - Memory is no longer allocated when it goes out of scope. (i.e. you shouldn't return a pointer to an object on the stack)

As far as which one to use; you choose the method that works best for you, given the above constraints.

- Some easy cases:
  - If you don't want to worry about calling delete, (and the potential to cause memory leaks) you shouldn't use new.
  - If you'd like to return a pointer to your object from a function, you **must** use new



## Dynamic Memory

### Vector

```cpp
int size = 5;                    // declare the size of the vector
vector<int> myvector(size, 0);   // create a vector to hold "size" int's
                                 // all initialized to zero
myvector[0] = 1234;              // assign values like a c++ array
```

### Map



### Array













## Caching

- [Introduction to caches](https://docs.roguewave.com/threadspotter/2011.2/manual_html_linux/manual_html/ch_intro_caches.html)

- branch prediction
- hot loops



## Dynamic Memory

**Pointer size**

However, most contemporary operating systems of general purpose (desktop UNIX-compatible systems, MS Windows) use data models where the pointer size corresponds to the capacity of the address bus employed by the architecture of these platforms. The address bus (used to pass memory addresses between components, e.g. the cpu) width determines the size of addressable memory. For example, if the address bus width is 32 bits and the memory word size is one byte (the minimal addressable data amount), then the size of the addressable memory equals 2^32 bytes, which determines the optimal pointer size to be used for this platform.





## Basic Data Containers

- array vs linked list



#### std::vector

- usually implemented as [dynamic array](https://en.wikipedia.org/wiki/Dynamic_array)





## Performance of STD Containers



**Search: vector, set, unordered_set**

https://medium.com/@gx578007/searching-vector-set-and-unordered-set-6649d1aa7752



