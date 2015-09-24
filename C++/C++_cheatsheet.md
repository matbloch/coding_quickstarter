# C++-cheatsheet


## Table of contents

- [Debugging](#debugging)
- [Comments](#comments)
- [Basic Concepts](#basic-concepts)
- [Control structures](#control-structures)
- [Functions](#functions)
- [Pointers](#pointers)
- [Data structures](#data-structures)

##Debugging##

fatal error LNK1120: 1 nicht aufgeloeste externe Verweise.  
projekt > eigenschaften > linker > system > subSystem auf "Konsole (/SUBSYSTEM:CONSOLE)"




##Comments##

```cpp
/*
*	This is a comment
*/

// this also
```

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

###Using external files and libraries

> `lib::method` use method without inlcuding the library  
>  Example: `std::cout << "Test line\n";`


```cpp
#include <iostream>   // includes file from the include folder
#include "datei.cpp"
#include "../lib/camera_connector.hh"
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

##### Call by reference

```cpp
void swap(int &a, int &b) {
    int tmp = a; // "temporaerer" Variable den Wert von Variable a zuweisen
    a = b;       // set a to b
    b = tmp;     // and b to a, saved in tmp
}
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

###Extension

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


