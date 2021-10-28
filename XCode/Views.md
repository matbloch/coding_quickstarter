# Views







## Programmatic Views

- Create new `UIView` child class
- Create view instance in view controller

```cpp
@interface ViewController
    @property (strong, nonatomic) MyView *myView;
@end
@implementation ViewController
- (void)viewWillAppear:(BOOL)animated {
	self.myView = [[MyView alloc] init];
}
@end
```



## XIB (XML Interface Builder)

> a custom, reusable view



