# Advanced Task Definitions



### Task Base Classes

```python
class MyWorkerClass(celery.Task):
    def do_something(self):
        pass
```

**Option 1:** Base class for all tasks

- define `task_cls`  in celery app


```python
# Use "task_cls" to define a base class for all the tasks
celery = Celery(MODULE_NAME, backend=CELERY_RESULT_BACKEND, broker=CELERY_BROKER_URL,
                task_cls=MyWorkerClass)

@celery.task(bind=True)
def do_work(self, inputs):
    # through "self" we can now access methods of the base class
    self.do_something()
```

**Option 2:** Base class for specific tasks

- define `base` on task

```python
@celery.task(bind=True, base=MyWorkerClass)
def do_work(self, inputs):
    # through "self" we can now access methods of the base class
    self.do_something()
```

