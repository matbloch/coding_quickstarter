# Task Templates





## Declaring a Base Class

**Declaration**

```python
from celery import Task

class MyTaskBase(Task):
    pass
```

**Use template**

- `base` argument on `task`

```python
@app.task(base=MyTaskBase)
def do_something():
    pass
```

**Use template globally**

```python
from celery import Celery
app = Celery('tasks', task_cls='your.module.path:DatabaseTask')
```



## Initialization

- A task is **not** instantiated for every request, but is registered in the task registry as a global instance.
- This means that the `__init__` constructor will only be **called once per process**, and that the task class is semantically closer to an Actor.

**Task Initialization**

```python
from celery import Task

class NaiveAuthenticateServer(Task):
    
    def __init__(self):
        self.users = {'george': 'password'}

    def run(self, username, password):
        try:
            return self.users[username] == password
        except KeyError:
            return False
```



## Properties

```python
from celery import Task

class DatabaseTask(Task):
    _db = None

    @property
    def db(self):
        if self._db is None:
            self._db = Database.connect()
        return self._db
```

**Accessing task properties**

- define `base` class
- `<task_method_name>.<property_name>`

```python
@app.task(base=DatabaseTask)
def process_rows():
    for row in process_rows.db.table.all():
        process_row(row)
```





## Handlers



```python
from celery import Task

class TaskBase(Task):
    
    def on_success(self, retval, task_id, args, kwargs):
        """Success handler.

        Run by the worker if the task executes successfully.

        Arguments:
            retval (Any): The return value of the task.
            task_id (str): Unique id of the executed task.
            args (Tuple): Original arguments for the executed task.
            kwargs (Dict): Original keyword arguments for the executed task.

        Returns:
            None: The return value of this handler is ignored.
        """
        payload = args[0]
        self.notify_via_email(payload["email"])
        
    def after_return(self, status, retval, task_id, args, kwargs, einfo):
        """Handler called after the task returns.

        Arguments:
            status (str): Current task state.
            retval (Any): Task return value/exception.
            task_id (str): Unique id of the task.
            args (Tuple): Original arguments for the task.
            kwargs (Dict): Original keyword arguments for the task.
            einfo (~billiard.einfo.ExceptionInfo): Exception information.

        Returns:
            None: The return value of this handler is ignored.
        """

    def on_failure(self, exc, task_id, args, kwargs, einfo):
        """Error handler.

        This is run by the worker when the task fails.

        Arguments:
            exc (Exception): The exception raised by the task.
            task_id (str): Unique id of the failed task.
            args (Tuple): Original arguments for the task that failed.
            kwargs (Dict): Original keyword arguments for the task that failed.
            einfo (~billiard.einfo.ExceptionInfo): Exception information.

        Returns:
            None: The return value of this handler is ignored.
        """
        raw_payload = args[0]
        payload = json.loads(raw_payload)
        retry = kwargs["retry"]
        print("Incorrect Login attempt from IP: ", payload("ip"))
        self.log("error", payload)
        app.send_task("login_task", args=(raw_payload, retry + 1))
        
    def on_retry(self, exc, task_id, args, kwargs, einfo):
        """Retry handler.

        This is run by the worker when the task is to be retried.

        Arguments:
            exc (Exception): The exception sent to :meth:`retry`.
            task_id (str): Unique id of the retried task.
            args (Tuple): Original arguments for the retried task.
            kwargs (Dict): Original keyword arguments for the retried task.
            einfo (~billiard.einfo.ExceptionInfo): Exception information.

        Returns:
            None: The return value of this handler is ignored.
        """
```



## Signals



```python
from celery import Task

class TaskBase(Task):

   def send_event(self, type_, retry=True, retry_policy=None, **fields):
        """Send monitoring event message. This can be used to add custom event 
        types in Flower and other monitors."""
        pass
```











### Sharing Memory between Worker Processes

https://stackoverflow.com/questions/45459205/keras-predict-not-returning-inside-celery-task/49164854#49164854

- http://memcached.org/