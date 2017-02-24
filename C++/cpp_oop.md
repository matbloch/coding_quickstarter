# C++ Object Oriented Programming


## Class Definition

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
    // or
	this->length = len;
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

## initialization

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
    - If you'd like to return a pointer to your object from a function, you **must** use new


## Constructors
### Copy constructors

```cpp
MyClass( MyClass* other );
MyClass( const MyClass* other );

// leads to infinite loop!
MyClass( MyClass other );
```

**Compiler provided copy constructor**

```cpp
class MyClass {
  int x;
  char c;
  std::string s;
};
```
```cpp
MyClass::MyClass( const MyClass& other ) :
 x( other.x ), c( other.c ), s( other.s )
{}
```


## Class Members

### Ininitialization
**Call order**:
- Initialization list
- Constructor Body

#### Method 1: Class constructor
#### Method 2: Initialization list
- If a member class does not have a default constructor: It MUST be initialized wth an initialization list

```cpp
class A
{
    public:
        A() { x = 0; }
        A(int x_) { x = x_; }
        int x;
};
// Default Constructor of A is called anyways
class B
{
    public:
        B(){a.x = 3;}
    private:
        A a;
};
```
#### Method 3: Assignment

### Pointers



## Dynamic Memory


### Vector



```cpp
int size = 5;                    // declare the size of the vector
vector<int> myvector(size, 0);   // create a vector to hold "size" int's
                                 // all initialized to zero
myvector[0] = 1234;              // assign values like a c++ array
```


#### As Class member
-  No need to initialize it, as it gets automatically initialized in the constructor of your class and deallocated when your class is destroyed
- If, instead, you want to create the array only after a particular condition, you have to resort to a (smart) pointer and dynamic allocation

```cpp
class YourClass
{
    std::vector<int> myVector;

	public void addElementToEnd(int elem){
    	myVector.push_back(elem);
    }
    public void displaySize(){
    	std::cout << myVector.size() << std::endl;
    }
    // manipulation of the returned vector won't affect the class instance
    public std::vector<int> GetCopyOfVector(){
    	return myVector;
    }
    public void replaceElement(int newElem, int position){
		myVector.at(position) = newElem;
        // without range check
        myVector[position] = newElem;
    }
};
```

### Interface Methods
- Force implementation in member class

```cpp
class Box {
   public:
      // pure virtual function
      virtual double getVolume() = 0;
   private:
      double length;      // Length of a box
      double breadth;     // Breadth of a box
      double height;      // Height of a box
};
```

## Polymorphism - Base Class Container
- Collect multiple derived classes in common vector of base class point type

```cpp
#include <iostream>
#include <vector>
using namespace std;

class a
{
protected:
    int test;
public:
    virtual void SetTest(int arg) {test = arg;}
    int GetTest() {return test;}
};

class b : public a
{
public:
    void SetTest(int arg) {test = arg+1;}
};

class c : public a
{
public:
    void SetTest(int arg) {test = arg+2;}
};

int main()
{
    vector<a *> derivedClassHolder;
    derivedClassHolder.push_back(new b);
    derivedClassHolder.push_back(new c);
    derivedClassHolder.push_back(new a);
    derivedClassHolder.push_back(new c);
    derivedClassHolder.push_back(new b);

    for(int i = 0; i < (int)derivedClassHolder.size() ; i++)
    {
        derivedClassHolder[i]->SetTest(5);
    }

    for(int i = 0; i < (int) derivedClassHolder.size() ; i++)
    {
        cout << derivedClassHolder[i]->GetTest() << "  ";
    }
    return 0;
}

```
