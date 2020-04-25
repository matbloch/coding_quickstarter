# Task Routing and Worker Queues



## Task Queues

**Dispatching tasks to a specific queue**

```python
my_task = signature('tasks.do_stuff', queue="my_custom_queue")
```

**Selecting the Queue to work on**

- default queue name: `celery`

`celery -A proj worker -Q feeds`

`celery -A proj worker -Q feeds,celery`

**Change default Queue name**

`app.conf.task_default_queue = 'default'`



## Manual Routing

**Route definition**

When sending tasks, the routers are consulted in order. The first router that doesn’t return `None` is the route to use. 

```python
app.conf.task_routes = {'feed.tasks.*': {'queue': 'feeds'}}
```

```
task_routes = ([
    ('feed.tasks.*', {'queue': 'feeds'}),
    ('web.tasks.*', {'queue': 'web'}),
    (re.compile(r'(video|image)\.tasks\..*'), {'queue': 'media'}),
],)
```



## Dynamic Task Routing

**Webservice / Scheduler**

```python
celery = Celery(__name__)
celery.conf.update({
    'broker_url': os.environ['CELERY_BROKER_URL'],
    'imports': (
        'tasks',
    ),
    'task_routes': ('task_router.TaskRouter',),
    'task_serializer': 'json',
    'result_serializer': 'json',
    'accept_content': ['json']}
    
```



```python
class TaskRouter:
    def route_for_task(self, task, *args, **kwargs):
        if ':' not in task:
            return {'queue': 'default'}

        namespace, _ = task.split(':')
        return {'queue': namespace}
```





