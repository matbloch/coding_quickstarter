## Basic concepts

### Programm structure
Java program processing starts from the main() method which is a mandatory part of every Java program.

```java
// simple program
public class Main {		// filename: same as class, Main.java
    public static void main(String[] args) {
        System.out.println("Hello, World!");
    }
}

// program with arguments
public class Arguments {
    public static void main(String[] args) {
        for (int i = 0; i < args.length; i++) {
            System.out.println(args[i]);
        }
    }
}

```
### Compiling and running

Compile: `javac MyFirstClass.java`
Run: `java MyFirstClass`, with arguments `java MyFirstClass arg0 arg1 arg2`

### Error handling

**Catching**
```java
try {
//Code here
} catch (ExceptionHere name) {
    //Replace ExceptionHere with your exception and name with the name of your exception.
    //Code if exception "ExceptionHere" is thrown.
}
```
**Throwing**

```java
throw new IllegalArgumentException("Number not above 0");
```

You have to use the `throws` keyword when functions throw uncatched exceptions.

```java
// single exception
void mymethod(int num) throws IOException{
    if(num==1)
    	throw new IOException("Exception Message1");
}

// multiple exceptions
void mymethod(int num) throws IOException, ClassNotFoundException{
    if(num==1)
    	throw new IOException("Exception Message1");
    else
    	throw new ClassNotFoundException("Exception Message2");
} 
```

**Example exceptions**

- `ArrayIndexOutOfBoundsException`
- `IllegalArgumentException`
- `NullPointerException` Application attempts to use null in a case where an object is required
- `ArithmeticException` Thrown for example when a zero division occurs.
- `IOException`
- `IllegalAccessException` particular method not found
- `EmptyStackException`
- `ClassNotFoundException`


## Datatypes

Java is a strong typed language, which means variables need to be defined before we use them.

byte (number, 1 byte)
short (number, 2 bytes)
int (number, 4 bytes)
long (number, 8 bytes)
float (float number, 4 bytes)
double (float number, 8 bytes)
char (a character, 2 bytes)
boolean (true or false, 1 byte)

#### Characters and strings


```java
char c = 'g';					// create char
char s = "This is a string";	// create string
```

• **Concatenation**:
```java
String s3 = s1 + s2;

int num = 5;
String s = "I have " + num + " cookies";
```


#### Arrays

```java
// preallocation
int[] arr;

// direct definition
int[] arr = {1, 2, 3, 4, 5};

// access
arr[0] = 123;


```
**Array methods**
- `arr.length` number of elements



#### Enums

```java
class FreshJuice {

   enum FreshJuiceSize{ SMALL, MEDIUM, LARGE }
   FreshJuiceSize size;
}

public class FreshJuiceTest {

   public static void main(String args[]){
      FreshJuice juice = new FreshJuice();
      juice.size = FreshJuice. FreshJuiceSize.MEDIUM ;
      System.out.println("Size: " + juice.size);
   }
}
```

## Control structures

**if/else**
```java
int a = 4;
int result = a == 4 ? 1 : 8;
```

**== and equals**
```java
String a = new String("Wow");
String b = new String("Wow");

boolean r1 = a == b;      // This is false, since a and b are not the same object
boolean r2 = a.equals(b); // This is true, since a and b are logically equals
```

**for**
```java
for (int i = 0; i < 3; i++) {}
for (;i < 5;) {}	// shorthand
```

**while**
```java
while (condition) {}
```

**while**
```java
do {} while(condition);
```

**foreach**
```java
int[] arr = {2, 0, 1, 3};
for (int el : arr) {
    System.out.println(el);
}
```



## OOP

**Constructors**

```java
public class Puppy{

int puppyAge;

   public Puppy(){		// constructor with no input argument
   }
   public Puppy(String name){
      // This constructor has one parameter, name.
   }
   public void setAge( int age ){
       puppyAge = age;
   }
   public static void main(String []args){
      // Following statement would create an object myPuppy
      Puppy myPuppy = new Puppy( "tommy" );
	  myPuppy.setAge( 2 );
   }
}
```


**Reference**

```java
Student joe = new Student("joe");
Student s1 = joe;	// same object, s1 == joe: true


s1.name = "frank";	// changes also Student joe.name
s1.setName("frank"); // instead change as a reference

```


**Accessing parameters & methods**

```java
/* First create an object */
ObjectReference = new Constructor();

/* Now call a variable as follows */
ObjectReference.variableName;

/* Now you can call a class method as follows */
ObjectReference.MethodName();
```

**Accessebility**

- `public`: everybody has access
- `private`: only class itself has access

**Inheritance**

```java
class Circle extends Shape {
	// functions defined here will overwrite methods of the base class


}


```

### Abstract classes

**Abstract functions**

```java
abstract void moveTo(double deltaX, double deltaY);
```

**Abstract classes and member methods**
If a class includes abstract methods, then the **class itself must be declared abstract**.
```java
abstract class GraphicObject {
    int x, y;
    ...
    void moveTo(int newX, int newY) {
        ...
    }
    
    // these methods need to be defined specificly for each graphic object
    abstract void draw();
    abstract void resize();
}
class Circle extends GraphicObject {
    void draw() {
        ...
    }
    void resize() {
        ...
    }
}
class Rectangle extends GraphicObject {
    void draw() {
        ...
    }
    void resize() {
        ...
    }
} 

```

## Interfaces


## I/O