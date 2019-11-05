# Celery

> Asynchronous task queue/job queue based on distributed message passing

![celery](img/celery.jpg)











**example**: https://github.com/mattkohl/docker-flask-celery-redis



**How task scheduling works**

- Client sends new task to message broker
- message broker stores task in result backend
- worker fetches task over message broker
- saves task over message broker to result backend
- Client polls result backend for completed task

**Steps to integrate Celery**

1. Choose a Broker (e.g. Redis/Rabbit MQ)
2. Installing Cerery
3. Define tasks
4. Running the workers



## Basic Setup and Configuration



Celery config:

https://docs.celeryproject.org/en/latest/getting-started/first-steps-with-celery.html



## Starting a Celery worker

- start celery worker for `tasks` module:

`$ celery -A tasks worker --loglevel=info`







## Task Definition

#### Defining Tasks

- default broker port for Redis: `6379`

```python
from celery import Celery
MODULE_NAME = 'tasks'
BROKER_URL = 'redis://localhost:6379'
app = Celery(MODULE_NAME, broker=BROKER_URL)

@app.tasks
def add(x,y):
    return x + y
```



**Names**

```python
@app.task(name='sum-of-two-numbers')
def add(x, y):
    return x + y
```

**Importing Tasks**

- always use absolute imports
- or new-style relative imports

```python
from project.myapp.tasks import mytask
from .module import foo
```





### Logging

```python
from celery.utils.log import get_task_logger

logger = get_task_logger(__name__)

@app.task
def add(x, y):
    logger.info('Adding {0} + {1}'.format(x, y))
    return x + y
```





### Best-Practices



### Task Sets

```python

```













## Task Definition Primitives

http://docs.celeryproject.org/en/master/userguide/canvas.html#the-primitives

#### Basic Task Definition



```python
@app.task
def add(x, y):
    return x + y
```

**Bound tasks**

- access to `self`
- query state and access information about current request

```python
logger = get_task_logger(__name__)

@task(bind=True)
def add(self, x, y):
    logger.info(self.request.id)
```

**Task Inheritance**

- `base` arugment in definition

```python
class MyBase(celery.Task):
    def on_failure(self, exc, task_id, args, kwargs, einfo):
        print('{0!r} failed: {1!r}'.format(task_id, exc))
```

```python
@task(base=MyTask)
def add(x, y):
    raise KeyError()
```





### Signatures

- wraps arguments and execution option of a single task
- signatures of tasks can be passed into another process or to another function

**Extracting a Signature**

Option 1:

```python
from celery import signature
signature('tasks.add', args=(2, 2))
```

Option 2:

```python
add.signature((2, 2))
```

Option 3: Shortcut

`add.s(2, 2)`

**Passing Arguments to Signatures**

- supports keyword arguments

`add.s(2, 2, debug=True)`

**Partial Signatures**

```python
partial = add.s(2)
partial.delay(4)  # 4 + 2
```

**Immutable Signatures**

- `immutable=True`
- disallow partial arguments

```python
add.signature((2, 2), immutable=True)
```





----------

### Calling Signatures



Execute in current process

`add.s(2, 2)()`

Execute in a worker:

```python
result = add.delay(2, 2)
result.get()
```

Specifying options:

```python

```



--------

### Primitives

#### Chains

- links signatures sequentially (chain of callbacks)

```python
from celery import chain
res = chain(add.s(2, 2), add.s(4), add.s(8))()
```

#### Groups

- list of tasks that should be executed in **parallel**

```python
from celery import group
res = group(add.s(i, i) for i in xrange(10))()
```

**Result Status**

- `successful()` all subtasks were successfuly finished

- `failed()` if any subtaks failed
- `waiting()` if any subtask is not ready yet
- `ready()` if all subtasks are ready
- `completed_count()` Number of completed subtasks
- `join()` Gather all results and return in call order
- `revoke()` Abort tasks

#### Chord

- Group with additional callback that is executed after all tasks have finished
- synchronization is expensive; avoid chords if possible

```python
from celery import chord
res = chord((add.s(i, i) for i in xrange(10)), xsum.s())()
res.get()
```

#### Map

- Creates a temporary task where a list of arguments is applied to the task

` task.map([1, 2])` results in `res = [task(1), task(2)]`

#### Starmap

- Like map but arguments are applied as `*args`

`add.starmap([(2, 2), (4, 4)])`  results in `res = [add(2, 2), add(4, 4)]`

#### Chunks

- splits a long list of arguments into parts

**Example:**

- split arguments `[(0, 0), (1, 1), (2, 2) ,...]` into chunks **10**

- resulting in **100** tasks, each processing **10** items in sequence


```python
>>> items = zip(xrange(1000), xrange(1000))  # 1000 items
>>> add.chunks(items, 10)
```





## Task Execution

http://docs.celeryproject.org/en/master/userguide/calling.html#guide-calling

#### Executing Tasks

**NOTE:** this applies to tasks and signatures

- `T.apply_async(args, kwargs)`
  - **Example**: `task.apply_async(args=[arg1, arg2], kwargs={'kwarg1': 'x', 'kwarg2': 'y'})`
- `T.delay(*arg, **kwargs)`
  - **Example**: `task.delay(arg1, arg2, kwarg1='x', kwarg2='y')`
  - star argument version of `apply_async()`
  - doesn't support executino options (use `set()`)
- *calling* (`__call__`) 
  - **Example:** `task()`
  - executes task in current process



#### Callbacks/Errbacks

**Callbacks**

- `link=my_callback.s()`
- executed after taks was successful
- arguments: return value of parent task

```python
add.apply_async((2, 2), link=add.s(8))
```

**Errbacks**

- `link_error=my_error_handler.s()`

```
@app.task
def error_handler(uuid):
    result = AsyncResult(uuid)
    exc = result.get(propagte=False)
    print("Task {} raised exception".format(uuid))
    print(result.traceback)
    
add.apply_async((2, 2), link_error=error_handler.s())
```



#### Communicating State Changes

- `r.get(on_message=...)` callback on state update
- `self.update_state()` to emit status update

```python
@app.task(bind=True)
def hello(self, a, b):
    time.sleep(1)
    self.update_state(state="PROGRESS", meta={'progress': 50})
    time.sleep(1)
    self.update_state(state="PROGRESS", meta={'progress': 90})
    time.sleep(1)
    return 'hello world: %i' % (a+b)
```

```python
def on_raw_message(body):
    print(body)

r = hello.delay(1, 1)
final_result = r.get(on_message=on_raw_message, propagate=False)
```







## Task Scheduling

**From within the task code base**

```python
@app.tasks
def add(x,y):
    return x + y

add.delay(1, y=2)
add.apply_async(args=[1], kwargs={'y': 2})
```

**From outside the task code base**

- use `Celery` instance with same broker url

```python
from celery import Celery
MODULE_NAME = 'tasks'
BROKER_URL = 'redis://localhost:6379'
app = Celery(MODULE_NAME, broker=BROKER_URL)

app.send_task('tasks.add', (2,5))
```





## Fetching the Task Results





```python

```



## Task Monitoring



flower