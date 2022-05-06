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





### Types





**String**

```kotlin
val str = "abc 123"
// concatenation
str + 23
```

**Arrays**







### Type Checks and casts



```kotlin
if (obj is String) {
  
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









## Control Flow











## Logging

- see https://developer.android.com/reference/android/util/Log



```kotlin
Log.v("my-tag", "index=" + i);
```





