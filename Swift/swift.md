# Swift

### Misc

**Debugging**
- `print()`


**Comments**
- `/* hi ther */`
- `// hi there`


# Data Structures
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
- if not set: `nil` value

```swift
// default value: "Hello"
var optionalString: String? = "Hello"
var optionalString2: String? = nil
// same as:
var optionalString3: String?
```

**Automatic Unwrapping of Optionals**
- Actual value is accessed with `!`, e.g.: `myOptional!`
- `!` instead of `?`

```swift
var optionalString3: String!
```

#### Enums
```swift
enum DaysofaWeek {
   case Sunday
   case Monday
   case Saturday
}
var weekDay = DaysofaWeek.Sunday
weekDay = .Sunday
switch weekDay {
   case .Sunday:
      print("Sunday")
   case .Monday:
      print("Monday")
}
```

**With associated value**
```swift
enum Student {
   case Name(String)
   case Mark(Int,Int,Int)
}
var studDetails = Student.Name("Swift 4")
var studMarks = Student.Mark(98,97,95)
switch studMarks {
   case .Name(let studName):
      print("Student name is: \(studName).")
   case .Mark(let Mark1, let Mark2, let Mark3):
      print("Student Marks are: \(Mark1),\(Mark2),\(Mark3).")
}
```

#### Structs
- best use: as custom data types

```swift

```


#### Strings

**String Concatenation**
```swift
let myVar = 5
let someText = "My variable is: \(myVar)"
someText += someText
```

**Multiline**
```swift
let quotation = """
I said "I have \(apples) apples."
And then I said "I have \(apples + oranges) pieces of fruit."
"""
```

**Properties**
- `.isEmpty`


#### Arrays

**Initialization**
```swift
var myList = ["a", "b"]
// with typedef
var someInts:[Int] = [10, 20, 30]
// with initializer
var someInts = [Int](count: 3, repeatedValue: 0)
```

**Access**
```swift
someInts[0]
```

**Modification**
```swift
someInts.append(9)
someInts += 12
```

**Concatenation**
```swift
someInts1 + myInts2
```

**Iteration**
```swift
for item in someInts {}
for (index, item) in someInts.enumerated() {}
```

**Properties**
```swift
someInts.count
someInts.isEmpty
```

#### Sets
- unique values, unordered

```swift
var integerSet = Set<Int>()
integerSet.count
integerSet.insert(9)
integerSet.isEmpty
integerSet.remove(9)
integerSet.contains(9)
```

**Iteration**
```swift
for item in someSet {}
for item in someSet.sorted() {}
```

**Set Operations**
- `intersection`
- `union`
- `subtraction`

```swift
let evens: Set = [10,12,14,16,18]
let odds: Set = [5,7,9,11,13]
let primes = [2,3,5,7]
odds.union(evens).sorted()
// [5,7,9,10,11,12,13,14,16,18]
odds.intersection(evens).sorted()
//[]
odds.subtracting(primes).sorted()
//[9, 11, 13]
```

#### Tuples
- suitable for temporary data, not complex

**Unnamed**
```swift
var TupleName = (value1, value2,… any number of values)
print(TupleName.1)
```
**Keys**
```swift
var error501 = (errorCode: 501, description: “Not Implemented”)
print(error501.errorCode)   // prints 501.
```


#### Dictionaries
**Initialization**
```swift
var someDict = [KeyType: ValueType]()
var someDict = [Int: String]()
var someDict:[Int:String] = [1:"One", 2:"Two", 3:"Three"]
```

**From Array**
```swift
var cities = [“Delhi”,”Bangalore”,”Hyderabad”]
var Distance = [2000,10, 620]
let cityDistanceDict = Dictionary(uniqueKeysWithValues: zip(cities, Distance))
```

**Access**
```swift
var someVar = someDict["key"]
```

**Modification**
- `updateValue`
- `removeValue`
```swift
// update
var oldVal = someDict.updateValue("New", forKey: 1)
someDict[1] = "something"
// removal
someDict.removeValue(forKey: 2)
someDict[2] = nil
```

**Dict Operations**
- `filter`
- `grouping`

```swift
var closeCities = cityDistanceDict.filter { $0.value < 1000 }
```


**Iteration**
```swift

```


# OOP


----------

# Control Flow


**Range Operators**
```swift
(a...b)		// a till b
(a..< b)	// a till b, but not b
```

### Conditionals
- no brackets around condition

```swift
if varA < 20 {
} else if varA == 10 {

} else {

}
```


### Loops


**Array/Dict Iteration**
- `for value in myArray {}`
- `for (key, value) in myDict {}`



# Functions

**Definition**
```swift
func greet(person: String, day: String) -> String {
    return "Hello \(person), today is \(day)."
}
print(greet(person: "Hans", day: "Monday"))
```

**External parameter names**

```swift
func mult(first a: Int, second b: Int) -> Int {
	return a * b;
}
mult(first:3, second:4)
```

**Variadic Arguments**
```swift
func vari<N>(members: N...){
   for i in members {
      print(i)
   }
}
vari(members: 1, 2, 3)
```

**Tuple return**
```swift
func ls(array: [Int]) -> (large: Int, small: Int) {
	return (1000, 10)
}
print(ls(array: [1,2,3,4]).large)
```

**I/O parameters**
- `inout` keyword
- pass variable by ref `&`
```swift
func temp(a1: inout Int, b1: inout Int) {
   let t = a1
   a1 = b1
   b1 = t
}
temp(a1: &var1, b1: &var2)
```

**Function Types**

```swift
func sum(a: Int, b: Int) -> Int {
   return a + b
}
var addition: (Int, Int) -> Int = sum
print("Result: \(addition(40, 89))")
```

# Closures
- Self-containing blocks of functionality that can be passed around and used in code

```swift
{ (parameters) -> return type in
    statements
}
```

**Examples**

```swift
reversedNames = names.sorted(by: { (s1: String, s2: String) -> Bool in
    return s1 > s2
})
```
```swift
let divide = {
   (val1: Int, val2: Int) -> Int in 
   return val1 / val2 
}

let result = divide(200, 20)
```





