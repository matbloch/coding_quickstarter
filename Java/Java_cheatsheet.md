## Basic concepts



```java
public class Main {		// filename: same as class, Main.java


    public static void main(String[] args) {
        System.out.println("Hello, World!");
    }

}
```









public class MyFirstJavaProgram {

   /* This is my first java program.  
    * This will print 'Hello World' as the output
    */

    public static void main(String []args) {
       System.out.println("Hello World"); // prints Hello World
    }
} 


/*

public static void main(String args[])
Java program processing starts from the main() method which is a mandatory part of every Java program..

*/


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

## Functions


## OOP

// constructors - same name as class

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


// accessing parameters & methodsd

/* First create an object */
ObjectReference = new Constructor();

/* Now call a variable as follows */
ObjectReference.variableName;

/* Now you can call a class method as follows */
ObjectReference.MethodName();

## I/O