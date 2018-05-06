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




