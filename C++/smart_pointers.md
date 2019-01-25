# Smart Pointers

- Manage storage of pointer (providing limited garbage-collection facility)
- Only for object that can be allocated with **new** and deleted with **delete**





**Pointer Types**

- `unique_ptr` : **Single owner pointer**. Holding a pointer, providing interface for construction, ensure deletion on destruction
- `shared_ptr`: **Multiple owners pointer**.same as unique_ptr but allows copies of the pointer in multiple places (`unique_ptr` must be moved). Memory is freed when all objects that where holding the `shared_ptr` are destroyed (or realeased it).
- `weak_ptr`: **Non-owning pointer reference**. Reference (that can be invalidated) to object that is managed by a `shared_ptr`











### General

**Check if is set**

```cpp
//This checks if the object was reset() or never initialized
if (!pt) {}
if (pt != nullptr) {}
```





## shared_ptr

Release ownership of object as soon as:

- they destroy themselves
- their value changes
- if two shared_ptrs are created from same raw pointer, **both will be owning**, causing potential problems

### Initialization

```cpp
auto p1 = std::make_shared<myClass>(my_args);
// Ok, less efficient
auto p2 = std::shared_ptr<myClass>(new myClass(my_args));
```

**make_shared**

- no way to create two pointers to the same resource
- **new** operator for data structure only called once (one memory allocation)

**Copy/assignment**

```cpp
auto p2(p1);
auto p3 = p2;
```

**nullptr**

```cpp
auto p3 = std::shared_ptr<myClass>(nullptr);
std::shared_ptr<myClass> p4;	// equal
```

**swap**

- exchange contents between pointers

```cpp
std::shared_ptr<int> foo (new int(10));
std::shared_ptr<int> bar (new int(20));
foo.swap(bar);
```

**reset**

- eliminate one owner of the pointer

```cpp
p.reset();
p = nullptr;
p.reset(new int);
```

**Accessing the Raw Pointer**

```cpp
smart_pointer.get()
```





## unique_ptr

- there can be only 1 `unique_ptr` pointing at any one resource

```cpp
unique_ptr<T> myPtr(new T);       // Okay
unique_ptr<T> myOtherPtr = myPtr; // Error: Can't copy unique_ptr
```


## weak_ptr



