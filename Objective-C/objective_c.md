# Objective-C

## General

- `test.h` header file
- `test.m` implementation
- `;` line terminator
- `/**/` comments

**Logging**

- `%@` String
- `%d` Integer
```cpp
NSString *some_string;
NSLog(@"My string: %@", NEWLINE);
```

## Variables

```cpp
int    i, j, k;
char   c, ch;
float  f, salary;
double d;
```

## Methods

#### Instance Methods
- The minus (`-`) sign indicates an *instance* method
- *Instance* methods are called on an *instance* of a class - opposed to *class* methods, which are called on the class itself

**Definition**

- **Joining Argumeent** A joining argument is to make it easier to read and to make it clear while calling it.
- `:` parameter separation
- `()` type cast

```cpp
- (return_type) method_name:( argumentType1 )argumentName1
joiningArgument2:( argumentType2 )argumentName2 ...
joiningArgumentn:( argumentTypen )argumentNamen
{
   body of the function
}
```

**Example**
```cpp
- (int) max:(int) num1 secondNumber:(int) num2 {
   /* local variable declaration */
   int result;
   if (num1 > num2) {
      result = num1;
   } else {
      result = num2;
   }
   return result;
}
```

#### Declaration

**Structure**
```cpp
- (return_type) function_name:( argumentType1 )argumentName1
joiningArgument2:( argumentType2 )argumentName2 ...
joiningArgumentn:( argumentTypen )argumentNamen;
```

**Example**
```cpp
-(int) max:(int)num1 andNum2:(int)num2;
```

#### Function Call

```cpp

```
------------

## Standard Data Structures
#### Arrays

```cpp
double balance[5] = {1000.0, 2.0, 3.4, 17.0, 50.0};
double balance[] = {1000.0, 2.0, 3.4, 17.0, 50.0};
```

#### Strings

```cpp
NSString *greeting = @"Hello";
```

**from `char*`**
```cpp

char* cstring = "Try harder";
[NSString stringWithUTF8String:cstring];
// or
NSString* objcstring = @(cstring);
```

#### Structs
- `struct {Type}` for variable definition

```cpp
struct Books
{
   NSString *title;
   NSString *author;
   NSString *subject;
   int   book_id;
}
struct Books myBook;
myBook.title = @"Test Title";
```

#### Enums

```cpp
typedef NS_ENUM(NSInteger, TrackingState) {
    TrackingState1,
    TrackingState2
};
@property (nonatomic, readwrite) TrackingState trackingState;
```

#### NSData
- Data wrapper

```cpp

```


## Pointers

```cpp
int  *ptr = NULL;
int  var = 20;
ptr = &var;
if(ptr)     /* succeeds if p is not null */
if(!ptr)    /* succeeds if p is null */
if(ptr != nil)
```

- Object pointers by default set to `nil`


## Control Structures

## Imports

- `#import <...>` header needs NO guard
- `#include <...>` header needs include guard



## Objective C Containers

#### C Arrays

**Definition**
```cpp
// as variable
int threedim[5][10][4];
int a[5][2] = { {0,0}, {1,2}, {2,4}, {3,6},{4,8}};
double balance[] = {1000.0, 2.0, 3.4, 17.0, 50.0};
// as property (needs pointer access)
@property float (**corners) [4][2];
```

**Initialization**
```cpp

```


#### NSArray
```cpp
// init and add
NSArray *array = @[@[@"0:0", @"0:1"],
                   @[@"1:0", @"1:1"]];
// access elements
NSString *value = array[1][0];
```

**From C Array**

#### NSMutableArray

```cpp
NSMutableArray *liveSales = [[NSMutableArray alloc] init];
```

**Empty init**
```cpp
NSMutableArray *array = [[NSMutableArray alloc]init];
```

**Init with initial capacity**
```cpp
NSMutableArray *array = [NSMutableArray arrayWithCapacity:1];
```

**Add object**
```cpp
[myMutableArrayInstance addObject:myObj];
```

**Add non-Class objects**
```cpp
NSArray *points = [NSArray arrayWithObjects:
                     [NSValue valueWithCGPoint:CGPointMake(5.5, 6.6)],
                     [NSValue valueWithCGPoint:CGPointMake(7.7, 8.8)],
                     nil];
// access the value
NSValue *val = [points objectAtIndex:0];
CGPoint p = [val CGPointValue];
```

**Replace object**
```cpp
mutableArray[3] = @"someValue";
```

**Count elements**
```cpp
NSUInteger arrayLength = [myMutableArray count];
```

**Iterate**

```cpp
for(id item in myObjects) {
    NSLog(@"Found an Item: %@",item);
}
// static typing
for (NSString *tempObject in myArray) {
    NSLog(@"Single element: %@", tempObject);
}
```


#### Dictionaries

- Designed to deal with `object` keys (wrap identifiers in `NSString` or `NSNumber`)

```cpp
NSMutableDictionary *bookListing = [NSMutableDictionary dictionary];
```

**Setters**
```cpp
[bookListing setObject: @"Wind in the Willows"  forKey: @"100-432112"];
```

**Getters**
```cpp
[bookListing objectForKey:@"104-109834"];

if ([bookListing objectForKey:@"104-109834"]) {
      // "Key Exist"
}
```

**Removing**
```cpp
// single element
[bookListing removeObjectForKey: @"104-109834"];
// all elements
[bookListing removeAllObjects];
```

**Element Count**
```cpp
for (id key in myDict) {
	[myDict objectForKey:key]
}

// or
[dict enumerateKeysAndObjectsUsingBlock:^(id key, id obj, BOOL *stop) {
    NSLog(@"%@->%@",key,obj);
    // Set stop to YES when you wanted to break the iteration.
}];
```

**Iteration**

```cpp
int count = [bookListing count];
```


**Examples**

```cpp
NSMutableDictionary *bookListing = [NSMutableDictionary dictionary];
int myIdentifier = 123;
[bookListing setObject: @"Wind in the Willows"  forKey: [NSNumber numberWithInt:myIdentifier]];
```




#### Enums
- Put enums in public header
- Prefix state with class name
```cpp
// ClassA.h
typedef enum {
    ClassAStatusAccepted,
    ClassAStatusRejected
} ClassAStatus;
@interface ClassA {
    ClassAStatus status;
}
@end
// ClassB.h
typedef enum {
    ClassBStatusAccepted,
    ClassBStatusRejected
} ClassBStatus;
@interface ClassB {
    ClassBStatus status;
}
@end
```


## Multithreading
- it's never OK to do user interface work on the background thread


### Grand Central Dispatch (GCD)
- concurrency library via queues (First-In-First-Out)


##### Queues

**Serial Queues**
- tasks will run at a time, using only on thread at a time
- waits for task to finish until continuing with next one
- my switch to another thread for different task

**Main Queue**
- Special serial queue
- All tasks performed on main thread

##### Dispatching

- `dispatch_async`
- `dispatch_sync_f`
- `dispatch_async`
- `dispatch_sync_f`

##### Execution

**Async**
- dispatches to queue and returns immediately

```cpp
dispatch_async(dispatch_get_main_queue(),
^{
   // Some code
});
```

**Sync**
```cpp
dispatch_sync(dispatch_get_main_queue(),
^{
   // Some code
});
```

**Synchronizing Queues**

```cpp
dispatch_queue_t queue = dispatch_get_global_queue(DISPATCH_QUEUE_PRIORITY_DEFAULT, 0);
dispatch_group_t group = dispatch_group_create();

// Add a task to the group
dispatch_group_async(group, queue, ^{
   // Some asynchronous work
});

// Do some other work while the tasks execute.
// When you cannot make any more forward progress,
// wait on the group to block the current thread.
dispatch_group_wait(group, DISPATCH_TIME_FOREVER);

// Release the group when it is no longer needed.
dispatch_release(group);
```

**Delaying Execution**

```cpp
double delayInSeconds = 2.0;
dispatch_time_t popTime = dispatch_time(DISPATCH_TIME_NOW, (int64_t)(delayInSeconds * NSEC_PER_SEC));
dispatch_after(popTime, dispatch_get_main_queue(), ^(void){
  NSLog(@"Do some work");
});
```


## Notification Center

**Notify a UI change**
```cpp
dispatch_async(dispatch_get_main_queue(),^{
    [[NSNotificationCenter defaultCenter] postNotificationName:@"my_notification" object:nil];
});
```


# Persistent Data


- SQLite Database
- CoreData: Apple's persistency framework based on an object graph
- UserDefaults


### UserDefaults

**Can Store:**
- NSData
- NSString
- NSNumber
- NSDate
- NSArray
- NSDictionary

**Other Types**
- Wrap it in an instance of `NSData`, `NSNumber` or `NSString`


**Example:** Array of objects
- also works with `NSMutableArray`
```cpp
// To get the object:
NSUserDefaults* settings = [NSUserDefaults standardUserDefaults];
// To write a setting:
[settings setValue:@[@"A", @"B", @"C", @"D", @"E", @"F"] forKey:@"MostRecentlyUsed"];
[settings synchronize];
// To read a setting:
NSArray* mru = [settings arrayForKey:@"MostRecentlyUsed"];
```

##### Storing Structs

**Struct Definition**
```cpp
typedef struct
{
    int type;
    NSString *name;
} myStructure;
```

**NSData**
```cpp
// the struct
myStructure structure;

// make a NSData object
NSData *myData = [NSData dataWithBytes:&structure length:sizeof(structure)];

// make a new PacketJoin
myStructure newStructure;
[myData getBytes:&newStructure length:sizeof(newStructure)];
```


##### Storing Custom Classes

**Todo**
- Add protocol `NSCoding` to your class
- Implement:
	- `- (id)initWithCoder:(NSCoder *)decoder`
	- `- (void)encodeWithCoder:(NSCoder *)encoder`

**Encoder Methods**
```cpp
@interface Note : NSObject <NSCoding>
@property (nonatomic, copy) NSString *title;
@property (nonatomic) BOOL published;
@end

@implementation Note
- (id)initWithCoder:(NSCoder *)decoder {
  if (self = [super init]) {
    self.title = [decoder decodeObjectForKey:@"title"];
    self.published = [decoder decodeBoolForKey:@"published"];
  }
  return self;
}

- (void)encodeWithCoder:(NSCoder *)encoder {
  [encoder encodeObject:title forKey:@"title"];
  [encoder encodeBool:published forKey:@"published"];
}
@end
```

**Storing the Object as `NSData`**
```cpp
// receive user data
NSUserDefaults *currentDefaults = [NSUserDefaults standardUserDefaults];
// archive the custom object
NSData *data = [NSKeyedArchiver archivedDataWithRootObject:your_note];
// save it
[currentDefaults setObject:data forKey:@"MyNote"];
[currentDefaults synchronize];
// load and unarchive it
NSData *data = [currentDefaults objectForKey:@"MyNote"];
Note* my_save_note = [NSKeyedUnarchiver unarchiveObjectWithData:data];
```



## Memory Management in Objective-C

**In C++**
- local variables (de-)allocated automatically
- Object/ptr usually has single owner (you say: deallocate this now)

**In Garbage Colleted Language, e.g. Python**
- Object deleted if not used anymore


**In Objective-C**
- All ojbects allocated on the heap (i.e. new)
- Object can have multiple owners by default (you say: I'm not using this anymore)
