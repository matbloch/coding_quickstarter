# Classes and Objects in Objective-C

- Class is defined in two sections:
	- `@interface ... @end`
	- `@implementation ... @end`
- Almost everything is in form of object


## Interface/Implementation


**Interface**

- Defines the blueprint of a class
- All classes derived from base class `NSObject`

```cpp
@interface Box:NSObject
{
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

## Instance Variables (iVar)
- are private/protected
- defined in body of `interface`


## Properties
- for `public` attributes
- definition: `@property(ACCESS_SPECIFIERS) TYPE VARNAME;`
	```cpp
    @property (readonly) NSString *firstName;
    ```
- Introduced so instance variables can be accessed outside the class
- If properties are defined, getters and setters are automatically created:
	- `-(void) setVARNAME (TYPE) VARNAME;` setter
	- `-(TYPE) VARNAME;` getter
- Access specifiers:
	- `atomic`/`nonatomic`
	- `readwrite`/`readonly`
	- `strong`/`unsafe_unretained`/`weak`
- For `readwrite` properties, instance variables are automatically generated. With an underscore `_` prepanded.

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

#### Initializers
- Best practice: Have 1 designated initializer which is used in 

**Initializer with arguments**

```cpp
- (id)initWithX:(int)inPosX andY:(int)inPosY
{
	if ((self = [super init])) {
    	self.inPosX = inPosX;
        self.inPosY = inPosY;
    }
    return self;
}
```

**Custom Initializer**


```cpp
- (id)initWithFloat:(float)value;
NSNumber *magicNumber = [[NSNumber alloc] initWithInt:42];
```

.. implementation






## Constructor
- `NSObject` has base initializer method `init`

```cpp
Fraction *frac = [[Fraction alloc] init];
```

**Overloading the Default Initializer**

```cpp
- (id)init {
    if (!(self = [super init])) // init superclass
        return nil;
    myInt = 3;
}
```


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





## Examples

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





