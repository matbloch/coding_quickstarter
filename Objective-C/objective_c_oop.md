# Classes and Objects in Objective-C

- Class is defined in two sections:
	- `@interface ... @end`
	- `@implementation ... @end`
- Almost everything is in form of object


## Interface/Implementation

**Interface**
- Defines the blueprint of a class
- All classes derived from base class `NSObject`
- only instance variables (see further below) inside `{}` - Functions and properties only outside

```cpp
@interface Box: NSObject {
    double length;   // instance variable
}
@property NSString *objectLabel;	// property
- (void)someMethod;	 // method
@end
```

**Implementation**
- defines internal behaviour of class

```cpp
@implementation Box
-(void)myFunc: (int) inputInt {
	NSLog(@"The input: %d", inputInt);
}
@end
```



## Instance vs. Class (static) Methods

- Instance: `-` in definition
- Class: `+` in definition

```cpp
@interface MyClass : NSObject
+ (void)aClassMethod;
- (void)anInstanceMethod;
@end
```


**Call Signature**

```cpp
// call on class
[MyClass aClassMethod];
// call on instance
MyClass *my_instance = [[MyClass alloc] init];
[my_instance anInstanceMethod];
```


## Instance Variables (iVar)
- are private/protected
- defined in body of `interface`
- Without a property, ivars can be kept hidden. In fact, unless an ivar is declared in a public header it is difficult to even determine that such an ivar exists.

**definition**
```cpp
@interface myClass : NSObject {
	// instance variables go here ...
    int my_var;
}
// properties go here ...
@end
```

**Accesss**
From inside class:
```cpp
self.my_var = 123;
```


## Properties
- for `public` attributes
- definition: `@property(ACCESS_SPECIFIERS) TYPE VARNAME;`
	```cpp
    @property (readonly) NSString *firstName;
  ```
- Access specifiers:
	- **`atomic`**/`nonatomic`: atomic is thread safe
	- **`readwrite`**/`readonly` readonly: no setters generated
	- **`strong`**=`retain`/`weak`: strong: keep in heap
- Introduced so instance variables can be accessed outside the class
- If properties are defined, getters and setters are automatically created:
	- `-(void) setVARNAME (TYPE) VARNAME;` setter
	- `-(TYPE) VARNAME;` getter
- Access specifiers:
	- `atomic`/`nonatomic`
	- `readwrite`/`readonly`
	- `strong`/`unsafe_unretained`/`weak`
- For `readwrite` properties, instance variables are automatically generated. With an underscore `_` prepanded.


**Access specifier Examples**
- `retain`: used for pointer to an object
	- `@property (nonatomic, retain) ARWorldTrackingConfiguration *arConfig;`
- `assign`(default): when non-pointer attribute
- `copy`: when object is mutable

**Accessing Properties:** Option 1 - Accessors
```cpp
@interface XYZPerson : NSObject
@property NSString *firstName;
@end
// set it
[somePerson setFirstName:@"Johnny"];
```

**Accessing Properties:** Option 2 - Dot Syntax
```cpp
@interface XYZPerson : NSObject
@property NSString *firstName;
@end
// use the dot syntax, which is an accessor wrapper
NSString *firstName = somePerson.firstName;
somePerson.firstName = @"Johnny";
```

**Accessing Member Properties:**
```cpp
- (void)someMethod {
   NSString *myString = @"An interesting string";
   self.someString = myString;
   // or with accessor:
   [self setSomeString:myString];
}
```

**Renaming Accessors**
```cpp
@property (readonly, getter=isFinished) BOOL finished;
```

**Synthesized Instance Variables**
- For a property `prop` the compiler will automatically synthesize an instance variable `_prop`
- The iVar can be accessed inside the class
```cpp
[_undoManager doSomething];         // iVar
[self.undoManager doSomethingElse]; // Use generated getter
```

**Renaming Synthesized Instance Variables**
- using keyword `@synthesize`
- not mandatory any more

```cpp
@implementation SomeClass
@synthesize undoManager;	// explicitely define iVar
@end
// access
[undoManager doSomething]; // iVar
[self.undoManager doSomethingElse]; // Use generated getter
```



## Methods Calls

- Communication through brackets `[]`
- **Example** `[somePerson sayHello];`
	- call `sayHello`
	- on instance `somePerson`

#### External Calls

**Return Values**
```cpp
-(int)magicNumber;
int interestingNumber = [someObject magicNumber];
```

**Single Argument**
```cpp
-(int)magicNumber(int input_number);
int interestingNumber = [someObject magicNumber:123];
```

**Multiple Argument**
- additional arguments are part of the method name

```cpp
- (void)driveCar:(Car *)car withPerson:(Person *)person;
[carController driveCar:car withPerson:person];
```

Example with class arguments:
```cpp
- (void)driveCar:(Car *)car;
- (void)driveCar:(Car *)car withPerson:(Person *)person;
// instantiate objects
CarController *carController = [[CarController alloc] init];
Car *car = [[Car alloc] init];
Person *person = [[Person alloc] init];
// call method with single argument
[carController driveCar:car];
// call method with multiple arguments
[carController driveCar:car withPerson:person];
```

#### Member Calls

**Member Method Calls**
```cpp
- (void)sayHello {
    [self saySomething:@"Hello, world!"];
}
- (void)saySomething:(NSString *)greeting {
    NSLog(@"%@", greeting);
}
```

**Super Class Calls**
```cpp
- (void)saySomething:(NSString *)greeting {
    NSString *uppercaseGreeting = [greeting uppercaseString];
    [super saySomething:uppercaseGreeting];
}
```

**Create Object Inside Method**
```cpp
- (NSString *)magicString {
    NSString *stringToReturn = "test"
    return stringToReturn;
}
// remember: object still exists, even if pointer gets out of scope
NSString * magicString = [someObject magicString];
```


## Memory Management and Initialization

- Memory is allocated dynamically for Objective-C objects
- `NSObject` provices a method `(id)alloc;` which handles that
	- `id` is a generic type specifier
- To create an object, you need to combine `alloc` with `init`
	- `new` combines both if no arguments are needed

```cpp
NSObject *newObject = [[NSObject alloc] init];
// is the same as
NSObject *newObject = [NSObject new];
```

**Never do this:**
- Init could return a different object, than the one allocated

```cpp
NSObject *someObject = [NSObject alloc];
[someObject init];
```

#### Overloading the Default Initializer

```cpp
- (instancetype)init {
    if (!(self = [super init])) // init superclass
        return nil;
    return self;
}
```

#### Custom Initializer
- **Best practice**: Have 1 designated initializer which is used in all other initializers

**Example:** Desginated Initializer
```cpp
// DESIGNATED INITIALIZER
- (id)initWithTitleAndAuthor:(NSString *)aTitle author:(NSString *)theAuthor {
	// call more specific initializer
    if (!(self = [super init])) // init superclass
    	return nil;
    self.author = theAuthor;
    self.title = aTitle;
    return self;
}
// CUSTOM INITIALIZER
- (id)initWithTitle:(NSString *)aTitle {
	// call more specific initializer
    return [self initWithTitleAndAuthor:aTitle author:@"anonymous"];
}
// GENERIC
- (id)init {
	// call initializer with arguments
    return [self initWithTitle:@”Task”];
}
```

**Call**
```cpp
- (id)initWithFloat:(float)value;
NSNumber *magicNumber = [[NSNumber alloc] initWithInt:42];
```



#### Variable Initialization

- initialized to default values:
	- int: 0
	- string: nil



## Inheritance
- Only 1 baseclass but multilevel inheritance
```cpp
@interface derived-class: base-class
```

**Access Control**
- derived class can access all private members of base class, defined in **interface**
- no access to private members in **implementation**



## Methods of `NSObject`

- `isEqual`
```cpp
if ([firstPerson isEqual:secondPerson]) {}
```
- `compare`
```cpp
if ([someDate compare:anotherDate] == NSOrderedAscending) {
```



## Categories

- Add methods to existing classes
- used to extend classes for specific use cases
- methods of category will be available for all instances of original and sub classes
- File naming: e.g. `NSString+MyAdditions.h`
- **Usage:** Just import category extension and base class will inherit properties

- **NOTE:** Classes are **added** to existing class definition - avoid **name clashes**



### Usage

**Interface Definition**

```cpp
@interface ClassName (CategoryName)
@end
```

**Implementation**

```cpp
@interface NSString(MyAdditions)
+(NSString *)getMagicString;
@end

@implementation NSString(MyAdditions)
+(NSString *)getMagicString{
    return @"Some serious magic here!";
}
@end
```

**Using the category**

```cpp
#include "NSString+MyAdditions.h"
NSString *magic = [NSString getMagicString];
```



### Categories with Protocols



```objective-c
@interface NSDate (CategoryName) <ProtocolName>
@end

@implementation NSDate (CategoryName)
@end
```





### Anonymous Categories

- Extend internal implementation of a class
- Used to implement **hidden** properties - callable but not visible in public header

```cpp
@interface ClassName ()
@end

@interface XYZPerson ()
@property NSObject *extraProperty;
@end
```




# Passing Data Between Controllers

## 1-to-1: Calling a Method of the Super Controller
- Pass reference of super controller to child
- Call super controller method from child and pass data

*MainViewController.h*
```cpp
- (void)newDataArrivedWithString:(NSString *)aString;
- (void)showChildController
{
    ChildController *childController = [[ChildController alloc] init];
    childController.mainViewController = self;
    [self presentModalViewController:childController animated:YES];
    [childController release];
}
```

*ChildController.h*
```cpp
// forward declaration
@class MainViewController;
@interface ChildController : UIViewController
@property (nonatomic, retain) MainViewController *mainViewController;
- (void)passDataToMainViewController {
    NSString * someDataToPass = @"foo!";
    [self.mainViewController newDataArrivedWithString:someDataToPass];
}
@end

```

## 1-to-Many: Key-Value-Observing

- KVO works with **setters** and **getters** (e.g. with dot notation)
- **NOT** with *iVar* access


#### Example

```cpp
@interface SomeObject : NSObject
// property to watch
@property (nonatomic, strong) NSString *theMessage;
-(void) changeMessage;
@end
// method that changes the property
@implementation SomeObject
-(void) changeMessage {
	self.theMessage = @"Hi there!";
}
@end
```

**Adding an Observer**
In super controller:
```cpp
SomeObject new_object = [[SomeObject alloc] init];
[self addObserver:new_object forKeyPath:@"theMessage" options:NSKeyValueObservingOptionNew context:nil];
```
**Adding a Property Change Callback**
```cpp
- (void)observeValueForKeyPath:(NSString *)keyPath ofObject:
   (id)object
   change:(NSDictionary *)change
   context:(void *)context {
    // retrieve the first view controller's message
    NSString *message = [(NSString *)object valueForKey:@"theMessage"];
    NSLog(@"The message was %@", message);
}
```

**If parent class already implements the observer callback**
- Some class might already implement `observeValueForKeyPath` (`NSObject` does not)

```cpp
[super observeValueForKeyPath:keyPath ofObject:object change:change context:context];
```



## 1-to-1: Protocols (Delegates)

**required/optional methods**
- required by default

```cpp
@protocol XYZPieChartViewDataSource
- (NSUInteger)numberOfSegments;
@optional
- (NSString *)titleForSegmentAtIndex:(NSUInteger)segmentIndex;
@required
- (UIColor *)colorForSegmentAtIndex:(NSUInteger)segmentIndex;
@end
```

**Adopting Protocols**

```cpp
@interface MyClass : NSObject <Protocol1, Protocol2, Protocol3>
@end
```

# Examples

**Example:** Full class definition

*Box.h*
```cpp
@interface Quad:NSObject
{
    double length;   // Length of a box
    double height;   // Height of a box
}
@property(nonatomic, readwrite) double height; // Property, creates getters/setters
- (double) volume;	// method
@end
```

*Box.m*
```cpp
#import Box.h

@implementation Box
- (double)volume {
	return length * height;
}
@end
```





