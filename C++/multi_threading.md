# Multi-Threading



**Examples**

- [Singleton](http://www.modernescpp.com/index.php/thread-safe-initialization-of-a-singleton)

- [Thread-Safe Initialization of Data](http://www.modernescpp.com/index.php/thread-safe-initialization-of-data)



- Difficulties

- - Access to data from multiple threads must be properly synchronized.
  - Locks, lock-free programming Immutable data structures.
  - Deadlocks
  - Not all problems can be parallelized without making algorithms more complex.
  - Communication between threads
  - lock-free, starvation free, forward progress guarantee. memory_order in C++.



## Measuring Performance



## The C++ Memory Model







## Other Concepts

- pipelining



## Std Lib Tools

### Threads

**std::thread**

```cpp

```

**std::thread::get_id**

```cpp

```



### Mutex Management

**std::lock_guard**

- guards for duration of scope
- locked once, unlocked at destruction

```cpp
std::mutex mutex;
int i = 0;
void safe_increment() {
    std::lock_guard<std::mutex> lock(mutex);
    ++i;
}
```

**std::unique_lock**

- general purpose mutex ownership wrapper
- can be unlocked/locked again (included delayed locking)
- unlocks by default upon destruction

```cpp
std::mutex mutex;
int i = 0;
void safe_increment() {
    {
        std::unique_lock<std::mutex> lock1;
        ++i;
    }
}
```



### Conditional Execution

**std::condition_variable**

Any thread waiting for the conditional variable has to:

1. acquire a `std::unique_lock<std::mutex>` on the same mutex as used to protect the shared variable
2. Execute `wait`, `wait_for`, `wait_until` which will automatically suspend the thread
3. The thread wakes up when:
   - The conditional variable is notified
   - A timeout expires
   - A spurious wakeup occurs

```cpp
std::mutex m;
std::condition_variable cv;
bool ready = false;

void do_work() {
    std::unique_lock<std::mutex> lk(m);
    cv.wait(lk, []{return ready;});
}

int main() {
    std::thread worker(do_work);
    {
        // do stuff before worker thread
        std::lock_guard<std::mutex> lk(m);
        ready = true;
    }
    // wake worker up
    cv.notify_one();
    worker.join();
}
```



## Futures

- Read-only container for result that does not yet exist
- Provides mechanism to access result of async operation



```cpp
std::future<int> future = std::async(std::launch::async, [](){
    std::this_thread::sleep_for(std::chrono::seconds(5));
    return 42;
});
// wait until result is available
int val = future.get();
```



**Waiting for results**

- `wait()`
- `wait_for(duration)`
- `wait_until(timepoint)`
- `valid()` returns `false` if future has already been consumed (through `get()`)



**Example:** Spawning multiple tasks

```cpp
std::vector<std::future<size_t>> futures;
for (size_t i = 0; i < 10; ++i) {
    futures.emplace_back(std::async(std::launch::async, [](size_t param){
        std::this_thread::sleep_for(std::chrono::seconds(param));
        return param;
    }, i));
}
std::cout << "Start querying" << std::endl;
for (auto &future : futures) {
    std::cout << future.get() << std::endl;
}
```







## Promises







## Atomics



#### Sequential Consistency



#### Acquire-Release Semantics



- see [Blog](http://www.modernescpp.com/index.php/acquire-release-semantic)



-----------------

## Misc







