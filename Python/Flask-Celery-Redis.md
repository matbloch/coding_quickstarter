# Flask & Celery & Redis



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





### Task Sets





```python

```









### Chords

- task that only executes after all tasks in taskset have finished
- synchronization is expensive; avoid chords if possible









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



#### Linking Tasks and Error Callbacks

- `add.s()` is a signature

```python
add.apply_async((2, 2), link=add.s(16))
```

```
@app.tasks
def error_handler(uuid):
    result = AsyncResult(uuid)
    exc = result.get(propagte=False)
    print("Task {} raised exception".format(uuid))
    print(result.traceback)
    
add.apply_async((2, 2), link_error=error_handler.s())
```



## Fetching the Task Results

```python

```



## Task Monitoring



flower