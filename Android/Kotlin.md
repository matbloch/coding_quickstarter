# Kotlin

- source: https://kotlinlang.org/docs/





## Code Documentation



```kotlin
/**
 * A group of *members*.
 *
 * This class has no useful logic; it's just a documentation example.
 *
 * @param T the type of a member in this group.
 * @property name the name of this group.
 * @constructor Creates an empty group.
 */
class Group<T>(val name: String) {
    /**
     * Adds a [member] to this group.
     * @return the new size of the group.
     */
    fun add(member: T): Int { ... }
}
```





## Basic Types



### Variable Definition

- `val` keyword

```kotlin
val one = 1 // Int
```

**Type Annotation**

```kotlin
val b: Int = 10000
// nullable
val b: Int? = 10000
```

**Type Checks and casts**

```kotlin
if (obj is String) {
  
}
```



### Numbers

```kotlin
val one = 1 // Int
val threeBillion = 3000000000 // Long
val oneLong = 1L // Long
val oneByte: Byte = 1
```



```kotlin
val e = 2.7182818284 // Double
val eFloat = 2.7182818284f // Float, actual value is 2.7182817
```







### Strings

```kotlin
val str = "abc 123"
// concatenation
str + 23
```



### Arrays



```kotlin
var Arr1 = arrayOf(1,10,4,6,15)  
var Arr2 = arrayOf<Int>(1,10,4,6,15)  
var Arr3 = arrayOf<String>("Surat","Mumbai","Rajkot")  
var Arr4 = arrayOf(1,10,4, "Ajay","Prakesh")  
var Arr5: IntArray = intArrayOf(5,10,15,20)  
```



### List



**creation**

```kotlin
// list of strings
val list = listOf('a', 'b', 'c')
// list of collections
val users: List<User> = listOf( User("Tom", 32), User("John", 64) )
```

**clone/copy**

```kotlin
val my_copy = series.toMutableList()
```

**add/remove**

```kotlin
val numbers = mutableListOf("one", "two")
numbers.add(5)
```



**properties**

```kotlin
println(list.size) // 3
```

**access**

```kotlin
println(list.indexOf('b')) // 1
println(list[2]) // c
```









## Data Manipulation



### Filtering

Filtering Lists

```kotlin
val numbers = listOf("one", "two", "three", "four")  
val longerThan3 = numbers.filter { it.length > 3 }
```

Filtering Maps

```kotlin
val numbersMap = mapOf("key1" to 1, "key2" to 2, "key3" to 3, "key11" to 11)
val filteredMap = numbersMap.filter { (key, value) -> key.endsWith("1") && value > 10}
```



### Sorting

**SortBy**

```kotlin
data class Movie(var name: String, var year: Int)
 
fun main() {
    val movies = mutableListOf(
        Movie("Joker", 2019), Movie("Aquaman", 2018),
        Movie("Logan", 2017), Movie("Irishman", 2019)
    )
    movies.sortBy { it.year }
    movies.forEach { println(it) }
}
```

**sortWith**

- in-place sorting
- can be cascaded

```kotlin
movies.sortWith(compareBy{ it.year }.thenBy { it.name })
```







### Splitting Containers

Last elements

```kotlin
list.takeLast(3)
```







## Control Structures



### If / Else

```kotlin
// With else
var max: Int
if (a > b) {
    max = a
} else {
    max = b
}
```

if assignment

```kotlin
val max = if (a > b) {
    print("Choose a")
    a
} else {
    print("Choose b")
    b
}
```

Ternary assignment

```kotlin
var small = if(num1>num2) num2 else num1
```

### For Loop

Iterate over items

```kotlin
for (item: Int in ints) {
    
}
```

Iterate of key, items

```kotlin
for ((index, value) in array.withIndex()) {
    println("the element at $index is $value")
}
```













## Functions



**Definition**

```kotlin
fun powerOf(number: Int, exponent: Int): Int { /*...*/ }
```

**Default arguments**

```kotlin
fun doIt(i: Int = 2): Int {
  return i
}
```







## Classes and Objects



### Regular classes

**Primary Constructor**

- primary constructor is part of class header
- primary constructors cannot contain any code
- initialization code is placed in `init` blocks (executed in same order as they appear)
- property initializers from class body can use primary constructor parameters

```kotlin
class Person(val firstName: String) { // class header
  // class body: member functions and properties
  val upperCaseName: String = firstName.toUpperCase()
  
  init {
    println("Construcion argument: ${name}")
  }
}
```

**Secondary Constructor**

```kotlin
class Car(val id: String, val type: String) {
    // the secondary constructor
    constructor(id: String): this(id, "unknown")
}
```





**Creating a class instance**

```kotlin
val customer = Customer("Joe Smith")
```

**Examples**



```kotlin
class Account {  
		var acc_no: Int = 0  
		var name: String? = null  
		var amount: Float = 0f  
  
    fun insert(ac: Int,n: String, am: Float ) {  
        acc_no=ac  
        name=n  
        amount=am  
        println("Account no: ${acc_no} holder :${name} amount :${amount}")  
    }  
  
    fun withdraw() {  
       // withdraw code  
    }  
  
    fun checkBalance() {  
        //balance check code  
     }  
  
}  
```













### Data classes

- main purpose is to hold data
- annotate with `data class` 

```kotlin
data class User(val name: String = "", val age: Int = 0)
```





### Enum classes

- `.values()` get all values
  - `name` name of the enum constant as a string

```kotlin
enum class Direction {
  NORTH,
  SOUTH,
  WEST,
  EAST
}
```

**Initializing enums**

```kotlin
enum class Day(val dayOfWeek: Int) {    
    MONDAY(1), 
    TUESDAY(2),
    WEDNESDAY(3), 
    THURSDAY(4), 
    FRIDAY(5), 
    SATURDAY(6),
    SUNDAY(7)
}
```



**Get enum by Name**

```kotlin
val cardType = CardType.valueOf(...)
```



**Enums with properties**

```kotlin
enum class CardType(val color: String) {
    SILVER("gray"),
    GOLD("yellow"),
    PLATINUM("black")
}
```

Access the property:

```python
val color = CardType.SILVER.color
```





## Operator Overloading

- see https://kotlinlang.org/docs/operator-overloading.html#indexed-access-operator 



**Unary prefix and Increment/Decrement Operators**

- `+a` : `a.unaryPlus()`
- `-a` : `a.unaryMinus()`
- `!a` : `a.not()`
- `a++` : `a.inc()`
- `a--` : `a.dec()` 

```kotlin
data class Point(val x: Int, val y: Int)

// implement the logic for "-point"
operator fun Point.unaryMinus() = Point(-x, -y)
```



**Arithmetic Operators**

- `a + b`
- `a - b`
- `a / b`
- `a * b`
- ...

```kotlin
data class Counter(val dayIndex: Int) {
    operator fun plus(increment: Int): Counter {
        return Counter(dayIndex + increment)
    }
}
```









## Dependency Injection

> Dependency is when one object depends on the concrete implementation of another object.
>
> **Dependency Injection** is the term used to describe the technique of loosening such coupling.



**Example**

- coupling between `Child` and `Parent`

```kotlin
class Parent {
    private val child = Child()
}
```

Dependency injection:

```kotlin
class Parent(private val child: Child)
```









## Logging

- see https://developer.android.com/reference/android/util/Log



```kotlin
Log.v("my-tag", "index=" + i);
```





