# C++-cheatsheet


## Table of contents


[TOC]



## Project setup

```cpp
- project_name
	+ cmake 		// CMake module path (.cmake files to find libraries)
	+ bin 			// output executables
	+ build			// all object files, gets removed on clean
	+ lib
	+ include		// all project and 3rd party header files  (*.h)
	+ src			// only the application source files (*.cpp)
	+ test			// all test code
	+ doc			// Any notes
	- README.md
	- CMakeLists.txt
```

###.gitignore

```git
# Ignore the build and lib dirs
build
lib/*

# Ignore any executables
bin/*

# Ignore Mac specific files
.DS_Store
```

###Makefile

###Code-Compile-Run procedure

## Headers and Includes

**Usage**
- To foraddeclare of functions and Classes

**File Extension**
- header files: (.h/.hpp/.hxx)
- Source files: (.cpp/.cxx/.cc)


### Include guards
Prevents including the same header file multiple times.

```cpp
//x.h
#ifndef __X_H___   // if x.h hasn't been included yet...
#define __X_H___   //   #define this so the compiler knows it has been included
class X { };
#endif
```

#### Circular dependencies
Use pointers or reference to objects rather than full object.


###Using external files and libraries

> `lib::method` use method without inlcuding the library  
>  Example: `std::cout << "Test line\n";`


```cpp
#include <iostream>   // includes file from the include folder
#include "datei.cpp"
#include "../lib/camera_connector.hh"
```


### Example Include Structure

**in myclass.h**
```cpp
// forward declaration
class MyClass
{
public:
  void foo();
  int bar;
};
```
**in myclass.cpp**
```cpp
// include forward declaration
#include "myclass.h"

// explicite declaration
void MyClass::foo()
{
}
```
**in main.cpp**
```cpp
#include "myclass.h"  // defines MyClass

int main()
{
  MyClass a; // no longer produces an error, because MyClass is defined
  return 0;
}
```


### Example Header

- Because `MyClass` only uses a pointer to Foo and not a full Foo object, we can forward declare Foo, and don't need to `#include "foo.h"`
- always forward declare when you're only using a pointer or reference

```cpp
//=================================
// include guard
#ifndef __MYCLASS_H_INCLUDED__
#define __MYCLASS_H_INCLUDED__

//=================================
// forward declared dependencies
class Foo;
class Bar;

//=================================
// included dependencies
#include <vector>
#include "parent.h"

//=================================
// the actual class
class MyClass : public Parent  // Parent object, so #include "parent.h"
{
public:
  std::vector<int> avector;    // vector object, so #include <vector>
  Foo* foo;                    // Foo pointer, so forward declare Foo
  void Func(Bar& bar);         // Bar reference, so forward declare Bar

  friend class MyFriend;       // friend declaration is not a dependency
                               //   don't do anything about MyFriend
};

#endif // __MYCLASS_H_INCLUDED__
``` 


##Debugging##

fatal error LNK1120: 1 nicht aufgeloeste externe Verweise.
projekt > eigenschaften > linker > system > subSystem auf "Konsole (/SUBSYSTEM:CONSOLE)"

###Exception Handling


##Basic concepts##


###The `main` function

```cpp
#include <iostream>
#include <string> //fuer Strings

using namespace std;

int main(){
	return 0;
}
```

###Variables

##### Initialization
```cpp
Datatype Name;  
Datatype Name1, Name2, Name3;  
Datatype Name1, Name2 = val;  
Datatype Name1 = Name2 = val;  
//Initialization: after cpp 11
Datatyp Name {value};
```

##### Variable names


> * numbers, alphabetic characters, and _   
> * must not start with a number   

##### Typecasting

`int a, b, c;`  
`int a = 100;`  
`std::size_t a = 0`		= unsigned int (e.g. use in for as counter loops)  
`short b = 3.1`					16 bit  
`double b = 3.14;`				32bit  
`float c = 3.14159;`			64bit  
`const int c = 1337;`				can't be changed  
`bool c = true;	`				true, 1, false, 0  
`char buchstabe = 'c';`  
`char buchstaben[] = 'abc';`	same as string  

##### Incremental/decremental operators
` a++ ` increment a by 1 but returns the current value of a  
` ++a ` increment a by 1  
` a-- ` decrement a by 1, return original value  
` a++ `  


###Input/output

```cpp
cin >> name;
cout << "hello world\n";	/* with new line */
cout << "hello" << name << endl;	/* new line and flush output buffer */
```

```cpp
printf ("%s, %d, %f \n","test", 2, 2.312);
```


##Control structures##


> `break;`		breaks the loop  
> `continue;`  continues the loop  

##### `if` Shorthand: (condition)?iftrue:iffalse

```cpp
if(a == b){}

else if(true){

}else{

}
```

##### `switch`

```cpp
switch(condition){
	case val1: /* do something;*/ break;
	case val2: /* do something;*/ break;
    case val3: /* do something;*/ break;
    default:   /* if no case matches, do this */
}
```

#####  `for`

```cpp
for( int a = 10; a < 20; a = a + 1 )
{
   statement(s);
}

// In C++ 11:

for( auto &elem:myVector )
{
   cout << elem << endl;
}
```


##### `while/do while`

```cpp
while(condition)   // condition at start
{
   statement(s);
}do{						
   statement(s);
}while( condition ); // condition at end
```


##Functions##

##### with return

```cpp
RETURNTYPE functionname(type1 argument1, char argument2 = "this is a default value"){

	return a;	// of type **RETURNTYPE**
}
```

##### without return

```cpp
void myfunc(arguments){
	cout << "hi there";
}
```

##### inline functions

```cpp
inline int addTwo(int val){
	return val + 2;
}

// now:
cout << addTwo(4) << endl;

```

##### Prototyping

> If function b needs function a, a must be initialized before b

```cpp
int a(int);	/* prototype */

int b(int x){
	return x + a(x);
}
int a(int x){
	return x + 2;
}
```

##### Pointer and Reference arguments

- Reference Argument: allways use const e.g. `void test(const &int inputvar)`

```cpp
void pointer_function(int* param){
	// dereference pointer and set pointed value to 7
	*param = 7;
}

int a = 4;
pointer_function(&a);

int *myVariable;
*myVariable = 3;
// alternatively
*myVariable = &4;

pointer_function(myVariable);
```
**Example 2**
```cpp
// pass a reference
void Foo(int &x)
{
  x = 2;
}

//pass a pointer
void Foo_p(int *p)
{
   *x = 9;
}

// pass by value
void Bar(int x)
{
   x = 7;
}
int x = 4;
Foo(x);  // x now equals 2.
Foo_p(&x); // x now equals 9.
Bar(x);  // x still equals 9.
```

**Example 3**
```cpp
void swap(int &a, int &b) {
    int tmp = a; // "temporaerer" Variable den Wert von Variable a zuweisen
    a = b;       // set a to b
    b = tmp;     // and b to a, saved in tmp
}

int a = 2;
int b = 3;
swap(&a, &b);

```

**Example 4**

```cpp
void ProcessImage(const cv::Mat &img, const cv::Mat &img_clr){

}

// image containers
cv::Mat image, image_color;
ProcessImage(image, image_color);
```

##### Default parameters

```cpp
int summe(int a, int b, int c = 0, int d = 0) {
    return a + b + c + d;
}
```

##### using global variable in function
> use the `::` operator

```cpp
int a = 2;

void myfunc(){
	return ::a;
}
```

##### Function overloading

> Multiple functions can be defined under the same name if they have different inputs/outputs

```cpp
int summe(int a, int b, int c, int d) {
    return a + b + c + d;
}

int summe(int a, int b, int c) {
    return a + b + c;
}

int summe(int a, int b) {
    return a + b;
}
```


- - -

##Pointers##

###Definition

```cpp
int  var = 20;   		/* actual variable declaration */
int  *ptr = NULL;       /* pointer variable declaration */

ip = &var;  /* store address of var in pointer variable*/
```

###Access

```cpp
/* access address */
cout << ip << endl;
/* access value */
cout << *ip << endl;
```

- `*x`	value pointed to by x
- `&x`	address of x
- `x.y`	member y of object x
- `x->y`	member y of object pointed to by x
- `(*x).y`	member y of object pointed to by x (equivalent to the previous one)
- `x[0]`	first object pointed to by x
- `x[1]`	second object pointed to by x
- `x[n]`	(n+1)th object pointed to by x

### Pointer vs References

###Examples

**Pointer to array**
Array name is a constant pointer to `&arrayName[0]`, the address of the first array element.


```cpp
double *p;
double balance[10];

// assign pointer
p = balance;	/* balance = &balance[0] */

// access pointer
cout << *p<< endl;
cout << *(p+2)<< endl;
```

**Pointer to Pointers**

```cpp
int  var;
int  *ptr;
int  **pptr;

var = 3000;
ptr = &var;
pptr = ptr;
```

- - -


##Compound data types##

###Struct

**Definition**

```cpp
// define
struct product {
  int weight;
  double price;
} ;

// define and init
struct product {
  int weight;
  double price;
} apple, banana, melon;
```

**Initialization**
```cpp
product apple;
```

**Access**
```cpp
apple.weight;
```

####Pointers to structures

**Definition**

```cpp
// definition
struct movie {
  string title;
};

// creation
movie amovie;
movie * pmovie;

// linking
pmovie = &amovie;
```

**Access**
```cpp
pmovie->title;
// equivalent
(*pmovie).title;
```

_ _ _


###Array

```cpp
int a[4];				// int array length 4
int a[4] = {1,2,3,4};
int a[3,2] = {{1,2}, {3,4}, {5,6}}	// **2D-array**: a[y,x], reihen eingeben

// init with variable
const int N = 4;
int a[N];	// only possible with const
```

####Unit offset Arrays
- **Problem**: Some algorithms want to start with `arrayName[1]` istead of `arrayName[0]` 


**Solution 1: Additional pointer**
```cpp
int numbers[] = {1,2,3,4};
int *p;
p = numbers-1; /* p points to the address one field before the array */
```

**Solution 2: Manipulate function input**
```cpp
someMethod(numbers-1, 4);	/* use the shifted address */
```

####Dynamic Memory

- Allocates memory for the object on the free store (This is frequently the same thing as the heap)
- Requires you to explicitly delete your object later. (If you don't delete it, you could create a memory leak)
- Memory stays allocated until you delete it. (i.e. you could return an object that you created using new)

**`new` Operator**
```cpp
cin >> i;	// read variable

int * foo;
foo = new int [i];	// dynamically allocate memory
```

![dynamic_memory.png](.\img\dynamic_memory.png)


**`delete` Operator**

```cpp
delete[] foo;	// releases memory allocated using `new`
```

**`nothrow` Method**
Returns null pointer instead of exception on fail.

```
foo = new (nothrow) int [5];
```

_ _ _


###Vector

> Vector = 2D Array   
> vector<Datatype> name (nr_elements);

##### Object methods

* `myVector.size()` get size of the vector
* `myVectors.push_back( elem )` add element at end
* `myVectors.insert ( elem , 200 )` add element at specific position


##### Examples

* Initialization/access

    ```cpp
    vector<int> myVector (10);
    myVector[2] = 7;			// assign value 7 to 3rd element

	// add elements to end
    vector<string> delimiters;
    delimiters = {"a", "bc", "lorem pisum"};
    ```

* Manipulation

    ```cpp
	// add elements to end
    vector<string> delimiters;
    delimiters.push_back(",");
    ```

* Iterate over vector

    ```cpp
    for(std::size_t i=0; i < myVector.size(); i++){
        cout << myVector[i] << endl;
    }
    ```


###Character sequences


```cpp
char myword[] = { 'H', 'e', 'l', 'l', 'o', '\0' };
char myword[] = "Hello";
```



_ _ _

###String


> Usage: `#include <string>`

##### Object methods

* `myString.size()` get size
* `myString.max_size()` get maximum size
* `myString.append(string2)` append strings 

- - -

## Templating

> `typename` vs `class`: basicly the same

### Templated functions

```cpp
template<typename TYPE>
TYPE Twice(TYPE data)
{
   return data * 2;
}
```

### Templated Classes

```cpp
template <class A_Type> class calc
{
  public:
    A_Type multiply(A_Type x, A_Type y);
    A_Type add(A_Type x, A_Type y);
};
template <class A_Type> A_Type calc<A_Type>::multiply(A_Type x,A_Type y)
{
  return x*y;
}
template <class A_Type> A_Type calc<A_Type>::add(A_Type x, A_Type y)
{
  return x+y;
}
```

- - -

## Multithreading
```cpp
#include <iostream>
#include <cstdlib>
#include <pthread.h>

using namespace std;

#define NUM_THREADS     5

void *PrintHello(void *threadid)
{
   long tid;
   tid = (long)threadid;
   cout << "Hello World! Thread ID, " << tid << endl;
   pthread_exit(NULL);
}

int main ()
{
   pthread_t threads[NUM_THREADS];
   int rc;
   int i;
   for( i=0; i < NUM_THREADS; i++ ){
      cout << "main() : creating thread, " << i << endl;
      rc = pthread_create(&threads[i], NULL, 
                          PrintHello, (void *)i);
      if (rc){
         cout << "Error:unable to create thread," << rc << endl;
         exit(-1);
      }
   }
   pthread_exit(NULL);
}


```


```cpp
class MyClass {
public: 
   void Start();
   void DoStuff( int limit );
};

MyClass foo;
boost::thread thread1( boost::bind( &MyClass::Start, &foo ) );
boost::thread thread2( boost::bind( &MyClass::DoStuff, &foo, 30 ) );
// threads do stuff here
thread1.join();
thread2.join();

```


- - -

##OOP##


### visibility

```cpp

class Line
{
   public:
      void setLength( double len );
      double getLength( void );
      Line(double len);  // This is the constructor

   private:
      double length;
};


// Member functions definitions including constructor
Line::Line( double len)
{
    cout << "Object is being created, length = " << len << endl;
    length = len;
}

void Line::setLength( double len )
{
    length = len;
}

double Line::getLength( void )
{
    return length;
}

```





```cpp

int main(int argc, char *argv[])

{

    Enemy *enemy = new Enemy();		// create pointer to object

    enemy->setHealth( 100 );	// member setHealth of object pointed to by enemy

    cout << "Der Gegner hat " << enemy->getHealth() << " Lebenspunkte.\n";

    delete enemy;

    return 0;

}

```

### initialization

```cpp
YourClass foo;

Rectangle rect (3,4);	// constructor with arguments

// Method 1
Foobar *foobar = new Foobar();
delete foobar; // TODO: Move this to the right place.


```


* Method 1 (using new)

    - Allocates memory for the object on the free store (This is frequently the same thing as the heap)
    - Requires you to explicitly delete your object later. (If you don't delete it, you could create a memory leak)
    - Memory stays allocated until you delete it. (i.e. you could return an object that you created using new)
    - The example in the question will leak memory unless the pointer is deleted; and it should always be deleted, regardless of which control path is taken, or if exceptions are thrown.

* Method 2 (not using new)

    - Allocates memory for the object on the stack (where all local variables go) There is generally less memory available for the stack; if you allocate too many objects, you risk stack overflow.
    - You won't need to delete it later.
    - Memory is no longer allocated when it goes out of scope. (i.e. you shouldn't return a pointer to an object on the stack)

As far as which one to use; you choose the method that works best for you, given the above constraints.

* Some easy cases:

    - If you don't want to worry about calling delete, (and the potential to cause memory leaks) you shouldn't use new.
    - If you'd like to return a pointer to your object from a function, you must use new


##Type aliases (typedef/using)##

typedef existing_type new_type_name;

##IO-stream##

```cpp
#include <iostream>
using namespace std;	// cout is in namespace std

int main()
{

	cout << "hi there" << endl;
	system("pause");			// don't close console
	return 0;
}
```


