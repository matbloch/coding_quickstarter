#Java OOP Cheatsheet


[TOC]


## 000. References and data passing

Everything in Java is pass-by-value: 
- `myClass Instance;` is a pointer to Instance.
- Parameters of functions are like local variables declared inside method

```java

Dog myDog = new Dog("Rex");

// pass reference value to function
changeDog(myDog);

public void function changeDog(Dog passedDog){

// works: change made on object passed by pointer "passedDog"
passedDog.changeName("Bello");

// does not work: "passedDog" pointer has changed but not object instance that it has pointed to (Dog Rex)
passedDog = new Dog("Fluffy");

}

```



## 001. Classes


**Declataion and Initialization**

```java
// declare/reserve space
myClass TestInstance;

// create object
TestInstance = new myClass();

// alternatively
myClass TestInstance = new myClass();

```

**Constructors**

- Same as Class name
- Without return type (without void)
- Can be overloaded

```java
public class Puppy{

	int puppyAge;

   public Puppy(){		// constructor with no input argument
   }
   public Puppy(String name){
      // This constructor has one parameter, name.
   }
   public void setAge( int age ){
       this.puppyAge = age;
   }
   public static void main(String []args){
      // Following statement would create an object myPuppy
      Puppy myPuppy = new Puppy( "tommy" );
	  myPuppy.setAge( 2 );
   }
}
```


**References**

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

**Method/Field accessability**

- `public`: everybody has access
- `private`: only class itself has access
- `protected`: within subclass and package

**Inheritance**

```java
class Circle extends Shape {
	// functions defined here will overwrite methods of the base class


}


```
-----
### Static Classes

- **Fields**: Bound to class (exists without instance), Identical for all instances
- **Methods**: can use Class itself inside declaration
- No access to instance attributes & instance methods in static methods
- `this` is not available


**Example**: Static methods with self reference
```Java
class Rectangle {
	intx, y, width, height;

	// can use Rectangle Type
    static Rectangle add(Rectangle r1, Rectangle r2) {
        //…
    }
}
```

**Example**: Static constructor

```
static {
colors[0] = black;colors[1] = new Color(255, 0, 0);colors[2] = new Color(0, 255, 0);}
```

----

### Abstract Classes
**Main usage:** Subclass for extension

- Abstract classes can not be instantiated: Must be extended at some point
- All other functionality still exists (constructor, fields, methods)


**Abstraction**



```java
public abstract class Employee
{
   private String name;
   private int number;
   public Employee(String name, String address, int number)
   {
      System.out.println("Constructing an Employee");
      this.name = name;
      this.address = address;
      this.number = number;
   }

   public String getName()
   {
      return name;
   }
   public int getNumber()
   {
     return number;
   }
}

```


**Abstract member functions**

- Useful for fixed class definitions, reminders
- If a class includes abstract methods, then the **class itself must be declared abstract**
- Any child class must either override the abstract method or declare itself abstract

```java
public abstract class Employee
{
   private String name;
   private String address;
   private int number;

   public abstract double computePay();

   //Remainder of class definition
}
```



## 002. Interfaces
- A class describes the attributes and behaviors of an object. An interface contains behaviors that a class implements.
- If class does not implement **all methods** of an implemented interface, it has to be abstract

**Differences from classes:**
- No instances
- No constructors
- All methods abstract
- Interface is not extended but implemented by class
- Interface can extend multiple interfaces

```java
[Modifikator] interface Interface
{
     [final] [Modifikator] Typ Variable = Wert;
  [abstract] [Modifikator] Typ Methode();
}
```


**Example**

```java
// Interface class, File name : Animal.java
interface Animal {
   public organism_type = "Multicellular";
   public void eat();
   public void travel();
}

// Main class, File name : MammalInt.java
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
**Extending interface extending interfaces**
```
public interface Hockey extends Sports, Event
```

### Polymorphism

```java
public interface Vegetarian{}
public class Animal{}
public class Deer extends Animal implements Vegetarian{}
```

