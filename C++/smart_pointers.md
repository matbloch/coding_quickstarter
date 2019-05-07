# Smart Pointers

- Manage storage of pointer (providing limited garbage-collection facility)
- Only for object that can be allocated with **new** and deleted with **delete**

**Two Memory Types**

- **Stack**: defined lifetime, e.g. scope of a function
- **Heap**: memory that needs to be freed again, eventually managed through smart pointers

**Pointer Types**

- `unique_ptr` : **Single owner pointer**. Holding a pointer, providing interface for construction, ensure deletion on destruction
- `shared_ptr`: **Multiple owners pointer**.same as unique_ptr but allows copies of the pointer in multiple places (`unique_ptr` must be moved). Memory is freed when all objects that where holding the `shared_ptr` are destroyed (or realeased it).
- `weak_ptr`: **Non-owning pointer reference**. Reference (that can be invalidated) to object that is managed by a `shared_ptr`. Use to break reference cycles.

**Performance**

- Stack > unique_ptr > shared_ptr
- due to atomic reference count



### General

**Check if is set**

```cpp
//This checks if the object was reset() or never initialized
if (!pt) {}
if (pt != nullptr) {}
```



## shared_ptr

- Reference counted
- Release ownership of object as soon as:
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
- **new** operator for data structure only called once (one memory allocation compared to allocating control block and data container).

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

### Initialization from this

- `std::shared_ptr<T>(this)` is not working
- Create `shared_ptr` reference to self using `std::enable_shared_from_this`
- Use **public** inheritance

```cpp
struct Good: public std::enable_shared_from_this<Good> { // note: public inheritance
    std::shared_ptr<Good> getptr() {
        return shared_from_this();
    }
};
```

**Initialization of the owner**

- caller of `std::shared_from_this` has to be owned by a `std::shared_ptr` (only for this method, others are fine)

```cpp
// correct usage
std::shared_ptr<Good> gp1 = std::make_shared<Good>();
std::shared_ptr<Good> gp2 = gp1->getptr();
// bad
Good not_so_good;
std::shared_ptr<Good> gp1 = not_so_good.getptr();
// fine
Good not_so_good;
not_so_good.do_something_else();
```

**Forcing `shared_ptr` creation**

- private construtor
- static factory method

```cpp
class MyObject {
  public:
  static std::shared_ptr<MyObject> create_object {
  	return std::make_shared<MyObject>();
  }
  private:
  	MyObject(){}
}
```



### Observers

**Accessing the Raw Pointer**

```cpp
smart_pointer.get()
```



### Multi-Threading

- Safe when altering the underlying object (atomic reference count)
- **Unsafe** when altering the instance in different threads 



## unique_ptr

- there can be only 1 `unique_ptr` pointing at any one resource
- no computational overhead - same as raw ptr under the hood

```cpp
unique_ptr<T> myPtr(new T);       // Okay
unique_ptr<T> myOtherPtr = myPtr; // Error: Can't copy unique_ptr
```

**Consuming Unique Ptr**

- `class_variable_(std::move(input));`



## weak_ptr

- doesn't increase reference count

#### Initialization

- Always need to be initialized from `std::shared_ptr`

```cpp
auto ptr = std::make_shared<int>(1337);  // ref-count 1 
std::weak_ptr<int> weak_ptr = ptr;       // ref-count 1
```



TODO