# Error Handling



### Making a Task Fail

**NOTE: ** The combination of `Ignore` and `update_state` does not seem to make the task fail, the overall status is still `PENDING`. In Redis, the state is updated correctly though.



- set task state to `FAILURE`
- raise `Ignore()` exception to ignore the results. Tasks that return a value count as successful.

```python
import traceback

@app.task(bind=True)
def task(self):
    try:
        raise ValueError('Some error')
    except Exception as ex:
        self.update_state(
            state=states.FAILURE,
            meta={
                'exc_type': type(ex).__name__,
                'exc_message': traceback.format_exc()
                'custom': '...'
            })
        raise Ignore()

```

### Registering Failure Callbacks

```python
import celery
from celery.task import task

class MyBaseClassForTask(celery.Task):

    def on_failure(self, exc, task_id, args, kwargs, einfo):
        # exc (Exception) - The exception raised by the task.
        # args (Tuple) - Original arguments for the task that failed.
        # kwargs (Dict) - Original keyword arguments for the task that failed.
        print('{0!r} failed: {1!r}'.format(task_id, exc))

@task(name="foo:my_task", base=MyBaseClassForTask)
def add(x, y):
    raise KeyError()
```



