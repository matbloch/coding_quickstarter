# Swift



## Misc

**Comments**
- `/* hi ther */`
- `// hi there`

**Imports**
- custom classes are available globally - no need to import
```swift
import UIKit
```

### Typecasting


**Check**
```swift
if myvar is MyClassType {}
```


**Type Casting/Checking**
- `?` optional, `!` must

```swift
// can fail
let song = item as? Song {}
// crashes if not possible
let song = item as! Song {}
```

**unwrapping**
```swift
if let song = item as? Song {}
```



## Project Structuring

- Extensions: `String+UTF8Data.swift`







## Debugging/Error Handling

- `print()`

**Preprocessor Macros**
- Set in: project settings > Build settings > "Lebels" > Preprocessor Macros
- Select the bild configuration: target -> Edit Scheme -> Run -> Info

Usage:
```swift
#if DEBUG
#else
#endif
```

### Assertions

```swift
assert(myVar != nil)
```

### Exceptions
**Definition**
- as enums, from `Error` protocol

```swift
enum NameError: Error {
  case noName
}

throw HeightError.minHeight
``

**Throwing**
- add `throws` to functions
- throw expections inside `guard`

```swift
func vend(itemNamed name: String) throws {
    guard let item = inventory[name] else {
        throw VendingMachineError.invalidSelection
    }
}
```

**Catching**
```swift
do {
  let myCourse = try Course(name: "")
} catch NameError.noName {
  print("Error: please make sure enter name!")
  // Logic
}
``

**Blocking Exceptions**

- `try?` returns `nil` on exception
- `try!` throws

```swift
let newCourse = try? Course(name: "Bob the Dev")
```


## Data Structures
#### Variables

- `var` Variables
- `let` Constants

```swift
var myVariable = 42
myVariable = 50
let myConstant = 42	// type inferred
let explicitDouble: Double = 70	// type defined
```


#### Null Savety

**Optional Variables**
- if not set: `nil` value

```swift
// default value: "Hello"
var optionalString: String? = "Hello"
var optionalString2: String? = nil
// same as:
var optionalString3: String?
```

**Access of optional values**
- once checked if nil, access value with `!`

```swift
if optional != nil {
	print("the value: \(optional!)")
}
if let constantName = someOptional {
    statements
}
```

**Automatic Unwrapping of Optionals**
- Actual value is accessed with `!`, e.g.: `myOptional!`
- `!` instead of `?`

```swift
var optionalString3: String!
```

**Guards**
- unwrapped variable still usable after clause
- `guard` statement must contain function control (`return`/`switch`/`break`)

```swift
guard let name = nameField.text else {
    show("No name to submit")
    return
}
print("my name is \(name)")
```



#### Enums
- Advanced usage: [Link](https://appventure.me/2015/10/17/advanced-practical-enum-examples/#sec-1-5-1)

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

**Case Checking**
```swift
if case .Sunday = weekDay {}
// AND
if case .Monday = weekDay, .Tuesday = weekDay {}
// OR

```

#### Structs
- best use: as custom data types
- **Cannot be altered by instance methodds**

**Member-wise Initialization**
```swift
struct Size {
    var width = 0.0, height = 0.0
}
let twoByTwo = Size(width: 2.0, height: 2.0)
```

**Instance mtehods**
- `mutating` keyword to modify instance variables

```swift
struct Stack {
    var items = [Int]() // Empty items array
    mutating func push(_ item: Int) {
        items.append(item)
    }
}
```

**Type/static methods**
```swift
struct absno {
   static func returnNo(number: Int) -> Int {
      return number
   }
}
```


#### Generic Types/Templates

```swift
struct Pair<T1, T2> {
	var first: T1
    var second: T2
}
var let floatPair = Pair<Float, Float>(first: 1.2, second: 1.5)
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
- `Array<TYPE>`
- `[TYPE]`
```swift
var myList = ["a", "b"]
// with typedef
var someInts:[Int] = [10, 20, 30]
var someInts:Array<Int> = [1, 2]
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
someInts.insert(100, at: 5)
```

**Concatenation**
```swift
someInts1 + myInts2
```

**Iteration**
```swift
for item in someInts {}
for (index, item) in someInts.enumerated() {}
someInts.forEach { value in
	...
}
```

**Properties**
```swift
someInts.count
someInts.isEmpty
```

**Search**
```swift
if let index = arr.index(of: val) {

}
```

**Mapping**
```swift
myarr.map {$0 + 10}
```

**Flattening**
```swift
let results = [[5,2,7], [4,8], [9,1,3]]
let allResults = results.flatMap { $0 }
// [5, 2, 7, 4, 8, 9, 1, 3]
```

#### Array Slices


#### Sets
- unique values, unordered
- Types must conform to `Hashable` protocol
	- Types must implement `readonly` proprety `hashValue` of type `Int`
	- Must implement equality operator

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
var someDict:[Int:String] = [1:"One", 2:"Two", 3:"Three"]
// empty
var someDict:[Int:String] = [:]
var someDict = [KeyType: ValueType]()
var someDict = Dictionary<Int, String>()
var someDict = [Int: String]()
```

**Inhomogeneous Dicts**
- `AnyHashable` and `Any` types

```swift
var mixedMap: [AnyHashable: Any]
if let unwrapped = wrapped.base as? String {

}
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
 for (key, value) in myDict {}
```


## Control Flow


- `guard`
- null check `.?`


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

### Guards
- `guard let ... else {}`


**Null Safety**

**Type Checking**
```swift
guard let ar_plane_anchor = anchor as? ARPlaneAnchor else {
	return
}
//negative type check
guard !(anchor is ARPlaneAnchor) else { return }
```

**Check if in `Dictionairy`**
```swift
guard let cars = devices["Car"] else {
    return
}
```


**Bundled Checks**
```swift

```


## Functions

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

**Optional Tuple Return**

```swift
func maybeGetHighScore() -> (String, Int)? {
    return nil
}
if let possibleScore = maybeGetHighScore() {
    possibleScore.0
    possibleScore.1
} else {
    print("Nothing Here")
}
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

### Completion Handlers
- function definition `completion`
- processing returns: `{() in }`

**Single Return**
```swift
// definition
func hardProcessingWithString(input: String, completion: (result: String) -> Void) {
	completion("we finished!")
}
// call
hardProcessingWithString("commands") {
	(result: String) in
	print("got back: \(result)")
}
```

**Multiple returns**

```swift
processItems(_ input: Int, completion: (Int, String)) -> Void) {
	for i in 0..<10 {
    	// return an item
    	completion(i, "String" + i)
    }
}

// call
processItems(123) { [unowed self] (var1, var2) in
	// called each time a value is returned
	print("Items: \(var1), \(var2)")
}

```


## Closures
- Self-containing blocks of functionality that can be passed around and used in code
- Init const variable

```swift
{ (parameters) -> return type in
    statements
}
```

**Examples**

**As argument**
```swift
reversedNames = names.sorted(by: { (s1: String, s2: String) -> Bool in
    return s1 > s2
})
```

**inline function**
```swift
let divide = {
   (val1: Int, val2: Int) -> Int in 
   return val1 / val2 
}

let result = divide(200, 20)
```

**initialization**
```swift
let someProperty: SomeType = {
    // create a default value for someProperty inside this closure
    // someValue must be of the same type as SomeType
    return someValue
}()
```

**lazy initialization**
```swift
func createButton(enterTitle: String) -> UIButton {
 let button = UIButton(frame: buttonSize)
 button.backgroundColor = .black
 button.titleLabel?.text = enterTitle
 return button
}
```

# Persistence





### `Codable`

> Allows do encode/decode structures

```swift
struct Product: Codable {
  var title:String
  var price:Double
  var quantity:Int
  enum CodingKeys: String, CodingKey {
    case title
    case price
    case quantity
  }
  init(title:String,price:Double, quantity:Int) {
    self.init()
    title = title
    price = price
    quantity = quantity
  }
  public func encode(to encoder: Encoder) throws {
    var container = encoder.container(keyedBy: CodingKeys.self)
    try container.encode(title, forKey: .title)
    try container.encode(price, forKey: .price)
    try container.encode(quantity, forKey: .quantity)
  }
  public init(from decoder: Decoder) throws {
    self.init()
    let container = try decoder.container(keyedBy: CodingKeys.self)
    title = try container.decode(String.self, forKey: .title)
    price = try container.decode(Double.self, forKey: .price)
    quantity = try container.decode(Int.self, forKey: .quantity)
  }
}
```









## Integrating C

- OpaquePointer: represent C pointers

```cpp

```

