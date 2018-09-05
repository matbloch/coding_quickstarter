# GCD - Grand Central Dispatch

**Queue Types**
- serial `main`: runs **serial** on main thread
- concurrent `global`: in concurrent queues shared by operating system
	- high, default, low and global background (io throttled) queues
- custom queues: can be created by user

**Queues Priority by Qualilty**
- userInteractive: serial main queue (UI updates)
- userInitiated: high priority queue
- default: default priority queue
- utility: low priority queue
- background: global background queue
- unspecified (lowest): low priority global queue

**Getting the Queues**

```swift
import Dispatch

DispatchQueue.main
DispatchQueue.global(qos: .userInitiated)
DispatchQueue.global(qos: .userInteractive)
DispatchQueue.global(qos: .default)
DispatchQueue.global(qos: .utility)
DispatchQueue.global(qos: .background)
DispatchQueue.global(qos: .unspecified)
```


**Synch vs Async**
- if you need return value: use `sync`
- in every other case: `async`
- **NEVER CALL SYNC ON MAIN QUEUE:** Deadlock


```swift
let q = DispatchQueue.global()
let text = q.sync {
    return "this will block"
}
print(text)
q.async {
    print("this will return instantly")
}
```

**Work Items**

### Examples

**Task in background - update in main**
```swift
DispatchQueue.global(qos: .background).async {
    // do your job here
    DispatchQueue.main.async {
        // update ui here
    }
}
```

**With delay**
```swift
DispatchQueue.main.asyncAfter(deadline: .now() + .seconds(2)) {
    //this code will be executed only after 2 seconds have been passed
}
```

**Loops**
```swift
DispatchQueue.concurrentPerform(iterations: 5) { (i) in
    print(i)
}
```

**Task in background - update in main**
```swift
```