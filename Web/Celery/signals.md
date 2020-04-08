# Celery Signals



http://docs.celeryproject.org/en/master/userguide/signals.html





## Worker Signals





### worker_process_init

- Dispatched in all pool child processes when they start.
- Note that handlers attached to this signal mustn’t be blocking for more than 4 seconds, or the process will be killed assuming it failed to start.
- Use `asynpool.PROC_ALIVE_TIMEOUT` to increase timeout



**Example**: Worker setup routine

```python
from celery.signals import worker_process_init
from celery.concurrency import asynpool

# Increase the setup timeout duration
asynpool.PROC_ALIVE_TIMEOUT = 100.0 

# Setup the Celery application
CELERY_BROKER_URL = 'redis://localhost:6379/'
CELERY_RESULT_BACKEND = 'redis://localhost:6379/'
app = Celery('tasks', backend=CELERY_RESULT_BACKEND, broker=CELERY_BROKER_URL)

my_global_object = None

@worker_process_init.connect()
def on_worker_init(**_):
    global my_global_object
    my_global_object = 123

@app.task
def do_work(arg):
	# Worker now has access to the global object that was
    # setup after the "worker_process_init" signal
    return my_global_object
```







## Application Signals



- `on_after_finalize`
  - fired after all `tasks.py` imported and all possible receivers already subscribed



```python
from celery import Celery

app = Celery()

# Signal sent when app is loading configuration.
@app.on_configure.connect
def do_something(sender, **kwargs):
    pass

# Signal sent after app has prepared the configuration.
@app.on_after_configure.connect
def do_something(sender, **kwargs):
    pass
    
# Signal sent after app has been finalized.    
@app.on_after_finalize.connect
def do_something(sender, **kwargs):
    pass

# Signal sent in child process after fork.
@app.on_after_fork.connect
def do_something(sender, **kwargs):
    pass
```



