# Flask & Celery & Redis



- the flask app and the celery tasks have a different codebase (flask app doesn't need access to celery task module)
- flask app uses `name` attribute of a task and `celery.send_task` to submit a job without having access to the celery workers codebase



**example**: mattkohl/docker-flask-celery-redis



**Steps to integrate Celery**

1. Choose a Broker (e.g. Redis/Rabbit MQ)
2. Installing Cerery
3. Define tasks
4. Running the workers



### Using Redis as a Celery Broker

- default broker port for Redis: `6379`



**Defining Tasks**

```python
from celery import Celery
MODULE_NAME = 'tasks'
BROKER_URL = 'redis://localhost:6379'
app = Celery(MODULE_NAME, broker=BROKER_URL)

@app.tasks
def add(x,y):
    return x + y
```

**Starting a Celery worker**

- execute 

`$ celery -A tasks worker --loglevel=info`



