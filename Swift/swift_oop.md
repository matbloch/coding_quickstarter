# Swift OOP

**Definition**
```swift
class Student {
   let mark: Int
   // named initializer
   init(mark: Int) {
      self.mark = mark
   }
   // unnamed initializer
   init(_ mark: Int) {
   	self.mark = mark
   }
}

// init
let stud = Student(123)
let stud = Student(mark: 123)
```


### Misc




### Initialization
- **designated** initializer: standard `init` method
	- can call **designated** initializer from base class
- **convenience** initializer:
	- must call initializer from same class
	- must ultimately call a **designated** initializer

**Example**
```swift
class Food {
    var name: String
    init(name: String) {
        self.name = name
    }
    convenience init() {
        self.init(name: "[Unnamed]")
    }
}
```

**Failable Initializers**

```swift
struct Animal {
    let species: String
    init?(species: String) {
        if species.isEmpty { return nil }
        self.species = species
    }
}
let someCreature = Animal(species: "Giraffe")
// someCreature is of type Animal?, not Animal

if let giraffe = someCreature {
    print("An animal was initialized with a species of \(giraffe.species)")
}
```


### Properties
- `Class` properties are reference types
- `Structures`/`Enumerations` are value types

**Optional/Const/Default properties**
```swift
class Example {
    let number: Int	    // const
    var text: String?   // nill value
    var textNumber: Int = 123
    init(number: Int) {
    	self.number = number
    }
}
```

**Access**
```swift
Example.number
```

**Lazy Stored Property**
- initialized when first time accessed

```swift
class sample {
   lazy var no = number()    // `var` declaration is required.
}

class number {
   var name = "Swift 4"
}
```

### Computed Properties
- provide getter and optional setter

```swift
class Sample {
   var no1 = 0.0, no2 = 0.0
   var middle: (Double, Double) {
      get {
         return (no1, no2)
      }
      set(axis){
         no1 = axis.0; no2 = axis.1;
      }
   }
}
var result = Sample()
```

**Get**
```swift
result.middle
```

**Set**
```swift
// set (pass array)
result.middle = [0.0, 10.0]
```


### Methods


**Class Methods**

```swift
static func doSomething() {}
```


### Extensions



### Inheritance
- `super` keyword for parent access
- `override` to override method
- `final` to prevent overriding

```swift
class Parent {
	var no: Int
    init(_ Int: no) {
    	self.no = no
    }
}
class Child {
	init() {
    	super.init(123)
    }
}
```

**Overriding init**
- If `init` of subclass has same signature: user `override`

```swift
class A {
	var nr: Int
    init(_ nr: Int) {self.nr = nr}
}
class B: A {
	override init(_ nr: Int) {
    	super.init()
        self.nr = nr
    }
}
```


**Required Initializer**
- Subclasses must implement
```swift
class SomeClass {
    required init() {}
}
class SubClass: SomeClass {
	init(){}
}
```


### Memory
- Class instances: always passed by reference
- Structures/Enumerations: value types - use `mutate` keyword


### Subscript Declaration
- allows to define bracket `[]` operator functionality
- also for multiple parameters (e.g. for 2D array)

```swift
class daysofaweek {
   private var days = ["Sunday", "Monday", "Tuesday", "Wednesday",
      "Thursday", "Friday", "saturday"]
   subscript(index: Int) -> String {
      get {
         return days[index]
      }
      set(newValue) {
         self.days[index] = newValue
      }
   }
}
var p = daysofaweek()
print(p[0])
print(p[1])
print(p[2])
print(p[3])
```


### Examples

