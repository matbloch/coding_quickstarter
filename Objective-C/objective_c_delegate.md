# Objective-C Design Patterns


## Observer
-

## Notification
- interaction with destination object is one-way
- no acknowledgment or data sent back


## Delegate

- Delegate pattern: 1-to-1 relationship between a class and it's delegate

**Defining Callbacks**

```cpp
// DELEGATION PROTOCOL
@protocol DownloaderDelegate <NSObject>
- (void)downloadedData:(id)data;
@end

@interface Downloader : NSObject
@property(nonatomic, weak)id <DownloaderDelegate> delegate;
- (void) fromURL:(NSURL *)url;
@end

// IMPLEMENTATION
@implementation Downloader
- (void) fromURL:(NSURL *)url{
	// do something
    // then forward the result through the protocol
    [self.delegate downloadedData:myData];
}
@end
```

**Linking/Delegating the callbacks**

```cpp
@interface Sample : NSObject<DownloaderDelegate>
- (void)init;
@end

// IMPLEMENTATION
@implementation Sample
-(void)init{
    Downloader *downloader = [[Downloader alloc]init];
    // link delegate of "Downloader" to "self" to enable callbacks
    downloader.delegate = self;
    // call base method which triggers callback
    [downloader fromURL:[NSURL URLWithString: @"google.ch"]];
}
// delegated method
-(void)downloadedData:(id)data{
    NSLog(@"%@",data);
}
@end

```

**Multiple Delegates**

```cpp

```

