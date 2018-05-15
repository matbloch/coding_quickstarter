# Objective-C++

- Every `.m` file that `#import`s directly or indirectly C++ must be changed to Objective-C++ `.mm`

```cpp
@interface ObjC: NSObject {
    CppClass *_pCppClass;
}
- (id)init {
    self = [super init];
    if ( self ) {
        _pCppClass = new CppClass(5, "hello");
    }
    return self;
}
- (void)dealloc {
    delete _pCppClass;
    [super dealloc];
}
```



## Scenario 1: Import pure C++ classes



## Scenario 2: Mixing Objective-C with C++


**Problems**

- Standard C++ containers like `map` not available in Apple's Foundation, can not be included in header
- **Objective**: Remove every trace of C++ (mainly member types) from header files
- **Solution**: Use pointers and encapsulate everything in a class
	- "Pimpl"/"Pointer" to implementation theoreme





#### "Pimpl"/"Pointer to Implementation"
- **Idea**: Encapsulate implementation in pointer, forward declare class

*MyClass.h*
```cpp
struct MyClassImpl;
@interface MyClass : NSObject {
  @private
  struct MyClassImpl* impl;
}
// public method declarations...
- (id)lookup:(int)num;
// ...
@end
```

*MyClass.mm*
```cpp
#import "MyClass.h"
#include <map>
struct MyClassImpl {
  std::map<int, id> lookupTable;
};

@implementation MyClass
- (id)init
{
  self = [super init];
  if (self)
  {
    impl = new MyClassImpl;
  }
  return self;
}
- (void)dealloc
{
  delete impl;
}
- (id)lookup:(int)num
{
  std::map<int, id>::const_iterator found =
    impl->lookupTable.find(num);
  if (found == impl->lookupTable.end()) return nil;
  return found->second;
}
// ...
@end
```




## Limitations
- `this` and `self` cannot be used interchangably
- No constructors/Destructors can be added
- Calling C++ using Objective-C syntax will not work
- No inheritance between languages
- Exception handling not fully supporting



## Linking C Libarries

**Example:** Dynamic library `.dylib`
- **Headers:** Set header path in: "Project Settings > Search Path"
	- To *Header Search Paths*, if used as `<a/a.h>`
	- To *User Search Paths*, if used as `"a/a.h"`
- **Library**:
	- Go to "Project Settings > Search Path"
	- Add path to `.dylib` to "Library Search Path"









