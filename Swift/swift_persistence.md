# Persistence in Swift: JSON encoding

**Storage Types**
- `NSCoding` Binary storage
- `Codable` JSON format



# `NSCoding`

### Minimal Example

- `func encode(with aCoder: NSCoder)`
- `required convenience init?(coder aDecoder: NSCoder)`

**Conform to Protocol**
```swift
class TestClass: NSObject, NSCoding {
    var name: String = "Mark"
    override init() {
        super.init()
    }
    func encode(with coder:NSCoder) {
        coder.encode(name, forKey: "name")
    }
    required init(coder decoder: NSCoder) {
        name = decoder.decodeObject(forKey: "name") as! String
    }
}
```


**Encoding/Decoding with NSCoder**
```swift
let obj = TestClass()
let encoded: Data = try! NSKeyedArchiver.archivedData(withRootObject: obj)
let decoded = NSKeyedUnarchiver.unarchiveObject(with: encoded) as! TestClass
```


**Save to Filesystem**

```swift
// save
NSKeyedArchiver.archiveRootObject(books, toFile: "/path/to/archive")
// load
guard let books = NSKeyedUnarchiver.unarchiveObjectWithFile("/path/to/archive") as? [Book] else { return nil }
```

**Save to Application Data**

```swift
let defaults = UserDefaults.standard

// store values
defaults.set(25, forKey: "Age")
defaults.set(true, forKey: "UseTouchID")
defaults.set(CGFloat.pi, forKey: "Pi")

// read values
let age = defaults.integer(forKey: "Age")
let useTouchID = defaults.bool(forKey: "UseTouchID")
let pi = defaults.double(forKey: "Pi")
let savedArray = defaults.object(forKey: "SavedArray") as? [String]
```

**removing**
```swift
UserDefaults.standard.removeObject(forKey: "name")
```

**default value**
```swift
let name = NSUserDefaults.standard.string(forKey: "name") ?? "Unknown user"
```

**NSCoder with NSUserDefaults**

```swift
// Encode object into NSData
let data = NSKeyedArchiver.archivedData(withRootObject:bikes)

// Save encoded NSData into UserDefaults
UserDefaults.standard.set(data, forKey: "bikes")

if let data = UserDefaults.standard.object(forKey: "bikes") as? NSData {
    // Decode the NSData back into an object
    let bikes = NSKeyedUnarchiver.unarchiveObjectWithData(data)
}
```

#### Examples

**Enum**
```swift
enum Food: UInt32 {
    case pizza
    case pasta
}
private enum CodingKeys: String, CodingKey {
    case food
}
override func encode(with aCoder:NSCoder) {
	aCoder.encode(food.rawValue, forKey: CodingKeys.food.rawValue)
}
public required init?(coder aDecoder: NSCoder) {
	self.food = Food(aDecoder.decodeObject(forKey: CodingKeys.food.rawValue) as! UInt32)
}
```


# `Codable` JSON encoding

## Inheritance

**Example:** Without special types

```swift
class Drink: Decodable {
    var type: String
    var description: String

    private enum CodingKeys: String, CodingKey {
        case type
        case description
    }
}
```

```swift
class Beer: Drink {
    var alcohol_content: String

    private enum CodingKeys: String, CodingKey {
        case alcohol_content
    }

    required init(from decoder: Decoder) throws {
        let container = try decoder.container(keyedBy: CodingKeys.self)
        self.alcohol_content = try container.decode(String.self, forKey: .alcohol_content)
        try super.init(from: decoder)
    }
}
```

**Example:** Including custom types

```swift
override func encode(to encoder: Encoder) throws {
    try super.encode(to: encoder)
    var container = encoder.container(keyedBy: CodingKeys.self)
    try container.encode(employeeID, forKey: .employeeID)
}
required init(from decoder: Decoder) throws {
    try super.init(from: decoder)
    let values = try decoder.container(keyedBy: CodingKeys.self)
    total = try values.decode(Int.self, forKey: .total)
}

private enum CodingKeys: String, CodingKey {
    case total
}
```

## Tips and Tricks

**Getting Rid of Explicit Type Parameters**

```swift
extension KeyedDecodingContainer {
    public func decode<T: Decodable>(_ key: Key, as type: T.Type = T.self) throws -> T {
        return try self.decode(T.self, forKey: key)
    }

    public func decodeIfPresent<T: Decodable>(_ key: KeyedDecodingContainer.Key) throws -> T? {
        return try decodeIfPresent(T.self, forKey: key)
    }
}
```


```swift
final class Post: Decodable {
    let id: Id<Post>
    let title: String
    let webURL: URL?

    init(from decoder: Decoder) throws {
        let map = try decoder.container(keyedBy: CodingKeys.self)
        self.id = try map.decode(.id)
        self.title = try map.decode(.title)
        self.webURL = try? map.decode(.webURL)
    }

    private enum CodingKeys: CodingKey {
        case id
        case title
        case webURL
    }
}
```

**Saving to UserDefaults**

```swift
struct User: Codable {
    var id: String
    var name: String
    var age: Int
}
let user = User(id: "abc123", name: "Tim can Cook", age: 13)
if let encoded = try? JSONEncoder().encode(user) {
    UserDefaults.standard.set(encoded, forKey: "kUser")
}
```


# Storing Data


**Simple Examples**

```swift
// set
let defaults = UserDefaults.standard
defaults.set(25, forKey: "Age")
defaults.set(true, forKey: "UseTouchID")
defaults.set(CGFloat.pi, forKey: "Pi")
defaults.set("Paul Hudson", forKey: "Name")
defaults.set(Date(), forKey: "LastRun")
let array = ["Hello", "World"]
defaults.set(array, forKey: "SavedArray")
// get
let age = defaults.integer(forKey: "Age")
let useTouchID = defaults.bool(forKey: "UseTouchID")
let pi = defaults.double(forKey: "Pi")
let name = UserDefaults.standard.string(forKey: “name”) ?? “”
let savedArray = defaults.object(forKey: "SavedArray") as? [String] ?? [String]()
```

