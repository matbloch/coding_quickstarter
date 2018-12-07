
### Smart pointers


- `shared_ptr` functions the same way as `unique_ptr` – holding a pointer, providing the same basic interface for construction and using the pointer, and ensuring that the pointer is deleted on destruction.
- Unlike `unique_ptr`, it also allows copying of the shared_ptr object to another shared_ptr, and then ensures that the pointer is still guaranteed to always be deleted once (but not before) all `shared_ptr` objects that were holding it are destroyed (or have released it).
- You can only use these smart pointers to refer to objects allocated with new and that can be deleted with delete
- e.g. Boost/std shared pointers



```cpp
unique_ptr<troidee::PointCloudReconstruct> dense_mapper(new troidee::PointCloudReconstruct);

if(dense_mapper.get() == nullptr){
	// not correctly assigned
}

// always use smartvariable for pointer
void f(shared_ptr<int>, int);
int g();

void ok()
{
    shared_ptr<int> p( new int(2) );
    f( p, g() );
}

void bad()
{
    f( shared_ptr<int>( new int(2) ), g() );
}
```

**Allocate memory in loop**
```cpp
for(int i = 0; i < 10; ++i)
{
    smart_ptr<some_class> object(new some_class());
    //use object
} // object gets destroyed here automatically 
```
**Assigning an Adress to a boost pointer**

```cpp
boost::shared_ptr<Car> sptr;
Car object;
sptr = boost::shared_ptr<Car>(&object);
```

**delete pointed content**
```cpp
// shared_ptr::reset example
#include <iostream>
#include <memory>

int main () {
  std::shared_ptr<int> sp;  // sp is now a null pointer and evaluates to boolean false

  sp.reset (new int);       // takes ownership of pointer
  *sp=10;
  std::cout << *sp << '\n';

  sp.reset (new int);       // deletes managed object, acquires new pointer
  *sp=20;
  std::cout << *sp << '\n';

  sp.reset();               // deletes managed object

  return 0;
}
```

**Value assignment**
- no direct address assignement

```cpp
shared_ptr<int>   sp;
sp = new int(5);  		// ERROR!
sp.reset(new int(10));	// the right way
```

**Check if pointer is set**
- use as boolean
```cpp
if (!blah)
{
    //This checks if the object was reset() or never initialized
}
```

#### Unique vs. Shared pointeres
**Unique pointer**
- there can be only 1 unique_ptr pointing at any one resource

```cpp
unique_ptr<T> myPtr(new T);       // Okay
unique_ptr<T> myOtherPtr = myPtr; // Error: Can't copy unique_ptr
```
Pass pointer to function: pass by reference
```cpp
bool func( const SmartPointer& base, int other_arg);
// call
func(*some_unique_ptr, 42);
```


**Shared pointer**
```cpp
shared_ptr<T> myPtr(new T);       // Okay
shared_ptr<T> myOtherPtr = myPtr; // Sure!  Now have two pointers to the resource.
```


## STD

```cpp

// Use make_shared function when possible.
auto sp1 = make_shared<Song>(L"The Beatles", L"Im Happy Just to Dance With You");

// or
std::shared_ptr<Song> = make_shared<Song>(L"The Beatles", L"Im Happy Just to Dance With You");

// Ok, but slightly less efficient.
// Note: Using new expression as constructor argument
// creates no named variable for other code to access.
shared_ptr<Song> sp2(new Song(L"Lady Gaga", L"Just Dance"));

// When initialization must be separate from declaration, e.g. class members, 
// initialize with nullptr to make your programming intent explicit.
shared_ptr<Song> sp5(nullptr);
//Equivalent to: shared_ptr<Song> sp5;
//...
sp5 = make_shared<Song>(L"Elton John", L"I'm Still Standing");
```


**Check for null**

```cpp
if(ptr != nullptr){}
// or (overloaded boolean operator)
if(!ptr){}
```

**As Class members**


```cpp
class Device {
};

class Settings {
    std::shared_ptr<Device> device;
public:
    Settings(std::shared_ptr<Device> const& d) {
        device = d;
    }

    std::shared_ptr<Device> getDevice() {
        return device;
    }
};

int main() {
    std::shared_ptr<Device> device = std::make_shared<Device>();
    Settings settings(device);
    // ...
    std::shared_ptr<Device> myDevice = settings.getDevice();
    // do something with myDevice...
}
```
