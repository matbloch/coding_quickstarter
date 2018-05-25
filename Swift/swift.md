# Swift



### Data Structures


#### Variables

- `var` Variables
- `let` Constants

```swift
var myVariable = 42
myVariable = 50
let myConstant = 42	// type inferred
let explicitDouble: Double = 70	// type defined
```

**Optional Variables**

```swift
var optionalString: String? = "Hello"
```

#### Strings

**String Concatenation**
```swift
let myVar = 5
let someText = "My variable is: \(myVar)"
```

**Multiline**
```swift
let quotation = """
I said "I have \(apples) apples."
And then I said "I have \(apples + oranges) pieces of fruit."
"""
```

#### Arrays

```swift
var myList = ["a", "b"]
myList[0] = "c"
```

#### Dictionaries

```swift
var myDict = [
	"name": "Malcolm",
    "job": "mechanic"
]
myDict["job"] = "student"
```

----------

### Control Flow


**Array/Dict Iteration**
- `for value in myArray {}`
- `for (key, value) in myDict {}`

### I/O

```swift
print(myVar)
```

### Functions


```swift
func greet(person: String, day: String) -> String {
    return "Hello \(person), today is \(day)."
}
```




