# Launching Workers



## Launching a Celery Worker

- Celery worker controls multiple processes (configured through `--concurrency`)
- Worker distributes tasks among it's controlled processes



**From the command line**

`celery -A my_application worker --loglevel=debug`

- `-A`, `--app` application name
- `-c` `--concurrency`  `<concurrency>`  Number of child processes processing the queue.  The default is the number of CPUs available on your system. 

`my_application.py`

```python
celery = Celery(
    MODULE_NAME,
    backend=CELERY_RESULT_BACKEND,
    broker=CELERY_BROKER_URL
)
@celery.task
def task1(input):
    time.sleep(1)
    return input
```

**Through a script**

```python
app = Celery('proj',
             broker=CELERY_BROKER_URL,
             backend=CELERY_RESULT_BACKEND,
             include=['proj.tasks'])
if __name__ == '__main__':
    app.start()
```



#### Running worker as daemon

- see [daemonizing celery]("daemonizing celery.md")



## Optimizations



#### Task Distribution

- **default**: Even number of task onto each worker
- **fair**: Waiting to distribute tasks until each worker process is available for work

![celery_task_distribution](D:\dev\coding_quickstarter\Web\Celery\img\celery_task_distribution.png)



