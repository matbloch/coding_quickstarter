# Multi-Threading



**Examples**

- [Singleton](http://www.modernescpp.com/index.php/thread-safe-initialization-of-a-singleton)

- [Thread-Safe Initialization of Data](http://www.modernescpp.com/index.php/thread-safe-initialization-of-data)



## Measuring Performance







## The C++ Memory Model





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
- lockes for scope
- can be unlocked/locked again

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





## Atomics



#### Sequential Consistency



#### Acquire-Release Semantics



- see [Blog](http://www.modernescpp.com/index.php/acquire-release-semantic)



-----------------

## Misc







