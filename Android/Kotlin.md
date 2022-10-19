# Kotlin

- source: https://kotlinlang.org/docs/





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
fun doIt(i: Int = 2) {
  return i
}
```







## Classes and Objects



### Regular classes

**Constructors**

- primary constructor is part of class header
- primary constructors cannot contain any code
- initialization code is placed in `init` blocks (executed in same order as they appear)

```kotlin
class Person(firstName: String) {
  // ...
  init {
    println("Construcion argument: ${name}")
  }
}
```

**Creating a class instance**

```kotlin
val customer = Customer("Joe Smith")
```

**Class members**

Properties

```kotlin
class Address {
    var name: String = "Holmes, Sherlock"
    var street: String = "Baker"
    var city: String = "London"
    var state: String? = null
    var zip: String = "123456"
}
```



Functions











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





