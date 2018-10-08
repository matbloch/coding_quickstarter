# Swift Higher Order Concepts


## Protocols
- like interfaces
- todo: protocols vs inheritance


**Optionals**
```swift
@objc protocol CounterDataSource {
    @objc optional func increment(forCount count: Int) -> Int
    @objc optional var fixedIncrement: Int { get }
}
```

## Complex Enums

```swift
enum ShelfManagementModel {
    case retail(RetailModel)
    case retailProductInfo(RetailProductInfo)
    case logistics(LogisticsModel)
    case sortingPackages(SortingPackagesModel)
    case productReview(ProductReview)
    case empty
}

extension ShelfManagementModel: ShelfManagementModelColors {

    var color: UIColor {
        switch self {
        case .retail(let model): return model.color
        case .retailProductInfo(let model): return model.stockColor
        case .logistics(let model): return model.color
        case .sortingPackages(let model): return model.color
        case .productReview(let model): return model.color()
        default: return UIColor.clear
        }
    }
```


## Delegates

1. create delegate protocol
2. create delegate property
3. Adopt and implement
4. call delegate from delegating object



**Delegate protocol**
```swift
protocol customClassDelegate: AnyObject {
  func didFinishTask()
}
```



**Create Delegate Property**
```swift
class CustomClass {
	weak var delegate:customClassDelegate?
    func some_routine_that_gets_called() {
    	// call the delegate, if set
    	delegate?.didFinishTask()
    }
}
```


**Adopt Protocol to specify Delegation**
```swift
class MyOtherClass: customClassDelegate {
	var custom_class = CustomClass()
	init() {
    	custom_class.delegate = self
    }
    func didFinishTask() {
    	// call this function whenever some_routine_that_gets_called is called
    }
}
```


## Property Observers
- **Important**: Not invoced during initialization
	- closure invoces `didSet`: `({ self.foo = foo })()`

```swift
struct Human
{
    var name:String
    {
        willSet // "name" is ABOUT TO CHANGE
        {
            print("\nName WILL be set...")
            print("from current value: \(name)")
            print("to new value: \(newValue).\n")
        }
        didSet // "name" HAS CHANGED
        {
            print("Name WAS changed...")
            print("from current value: \(oldValue)")
            print("to new value: \(name).\n")
        }
    }
}
```

## Failable Initializers

```swift

```


