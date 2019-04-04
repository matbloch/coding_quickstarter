# Concurrency vs Parallelism


- Concurrency: run code independently of other code - when code is blocked in script 1, script 2 is executed
	- Useful to break things appart. Schedule and manage different parts
	- Greenlets perform scheduling of calls that would block the current thread
	- Performs especially well in I/O, networking apps with waiting time
- Parallelism: Execution of concurrent code simultaneously
	- Useful to do a lot of ressource intensive work
	- Threads: Expensive in terms of virtual memory and kernel overhead

# Gevent - Greenlets

The core idea of concurrency is that a larger task can be broken down into a collection of subtasks which are scheduled to run simultaneously or asynchronously, instead of one at a time or synchronously.

- Greenlets: Alternative to parallel process. Greenlets all run inside of the OS process for the main program but are scheduled cooperatively

## Spawning

```python
import gevent
from gevent import Greenlet

def foo(message, n):
    """
    Each thread will be passed the message, and n arguments
    in its initialization.
    """
    gevent.sleep(n)
    print(message)

# Initialize a new Greenlet instance running the named function
# foo
thread1 = Greenlet.spawn(foo, "Hello", 1)

# Wrapper for creating and running a new Greenlet from the named
# function foo, with the passed arguments
thread2 = gevent.spawn(foo, "I live!", 2)

# Lambda expressions
thread3 = gevent.spawn(lambda x: (x+1), 2)

threads = [thread1, thread2, thread3]

# Block until all threads complete.
gevent.joinall(threads)
```

## Events
- Asynchronous communication between Greeenlets
- E.g. Greenlets wait till Greenlet XY reaches certain state

```python
import gevent
from gevent.event import Event


evt = Event()

def setter():
    '''After 3 seconds, wake all threads waiting on the value of evt'''
    print('A: Hey wait for me, I have to do something')
    gevent.sleep(3)
    print("Ok, I'm done")
    evt.set()


def waiter():
    '''After 3 seconds the get call will unblock'''
    print("I'll wait for you")
    evt.wait()  # blocking
    print("It's about time")

def main():
    gevent.joinall([
        gevent.spawn(setter),	# sets evt in 3 sec
        gevent.spawn(waiter),	# waits till evt is set
        gevent.spawn(waiter),	# ...
        gevent.spawn(waiter),	# ...
        gevent.spawn(waiter),
        gevent.spawn(waiter)
    ])

if __name__ == '__main__': main()
```