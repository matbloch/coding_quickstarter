#Java Cheatsheet


[TOC]



## 001. Setup

### Standard Directory Layout


```java
- project_name
	+ bin 			// output executables
	+ src
		+ main
			+ java			// Application/Library sources
			+ resources		// Application/Library resources
			+ filters
		+ test
			+ java			// Test sources
			+ resources
			+ filters
		+ site	// Site
	+ doc			// Any notes
	- README.md
	- LICENSE.txt
```

---

### Project setup


---

### Packages
Used to avoid namespace conflicts

- `package {packageName}` on top of all source files that define the pack
- Put files in subdirectory named after the package name
- Inside package, every member has access to the package methods/classes without using the package name as a prefix (`Class1` instead of `packagename.Class1`)

#### Building packages

**File1:** Animal.java
```Java
package animals;

interface Animal {
   public void eat();
   public void travel();
}
```
**File2:** MammalInt.java

```java
package animals;

public class MammalInt implements Animal{

   public void eat(){
      System.out.println("Mammal eats");
   }

   public void travel(){
      System.out.println("Mammal travels");
   }

   public int noOfLegs(){
      return 0;
   }

   public static void main(String args[]){
      MammalInt m = new MammalInt();
      m.eat();
      m.travel();
   }
}
```

#### Importing packages
after the package statement and before the class declaration

```java
// import everything
import payroll.*;

// import specific class
import payroll.Employee;
```

#### Subpackages

Java file in path `src/main/java/edu/lmu/cs/scratch/A.java`
Corresponding package name `package edu.lmu.cs.scratch;`




## 002. Basic concepts

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
---

### Compiling and running

Compile: `javac MyFirstClass.java`
Run: `java MyFirstClass`, with arguments `java MyFirstClass arg0 arg1 arg2`

---

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


## 003. Datatypes and Primitives

Java is a strong typed language, which means variables need to be defined before we use them.

- byte (number, 1 byte)
- short (number, 2 bytes)
- int (number, 4 bytes)
- long (number, 8 bytes)
- float (float number, 4 bytes)
- double (float number, 8 bytes)
- char (a character, 2 bytes)
- boolean (true or false, 1 byte)

**Explicit**
```java
float testfloat = (float)234; // 234.0
int testint = (int)21.23; // 21


```

#### Variables
Same as in C++

-------------
#### Characters and strings


```java
char c = 'g';					// create char
char s = "This is a string";	// create string
```

**Concatenation**:
```java
String s3 = s1 + s2;

int num = 5;
String s = "I have " + num + " cookies";
```
-------

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

## 004. Control structures

**switch**
```java
switch(myvar){
	case 12: myvar = 11; break;
  default: break;

}
```

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

## 005. I/O


**Ressource loading:**
- location independent



### Resource names


- **absolute** like “/path/resource.xml”
- **relative** like “path/resource.xml” (relative to method call location)

**Example:**
> stream1: located in path/resource.xml
> stream2: located in my/location/path/resource.xml - in class path

```java
package my.location;

class ResourceFinder {

    public void findResources(){
       InputStream stream1 = 
            getClass().getResourceAsStream("/path/resource.xml");
       InputStream stream2 = 
            getClass().getResourceAsStream("path/resource.xml");
    }
}

```

### Methods

#### `getResource()`

- leading slash to denote the root of the classpath
- slashes instead of dots in the path
- you can call `getResource()` directly on the class.

**Example:**
```java
class TestClass {
	  public void loadFile() {
			URL url1 = TestClass.class.getResource("file.txt");
            URL url2 = getClass().getResource("file.txt");
	  }
}
```
## 006. Project Dependencies






## 010. Misc Libraries

### OpenCV3

#### CV Mat


```java
Mat m = new Mat(5, 10, CvType.CV_8UC1, new Scalar(0));

// change 2nd row
Mat mr1 = m.row(1);
mr1.setTo(new Scalar(1));

// change 6th col
Mat mc5 = m.col(5);
mc5.setTo(new Scalar(5));

System.out.println("OpenCV Mat data:\n" + m.dump());
```


## 011. Multithreading