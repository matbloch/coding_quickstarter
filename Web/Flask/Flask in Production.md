# Deploying FLASK Applications





## Optimizing performance with Gunicorn

https://medium.com/building-the-system/gunicorn-3-means-of-concurrency-efbb547674b7



- workers: Each of the workers is a UNIX process that loads the Python application. There is no shared memory between the workers.
- threads: Gunicorn also allows for each of the workers to have multiple threads.  In this case, the Python application is loaded once per worker, and each of the threads spawned by the same worker shares the same memory space.
- pseudo-threads (coroutines): E.g. using gevent



**Concurrency vs. Parallelism**

- Concurrency is when 2 or more tasks are being performed at the same time, which  might mean that only 1 of them is being worked on while the other ones  are paused.
- Parallelism is when 2 or more tasks are executing at the same time.

In Python, threads and pseudo-threads are a means of concurrency, but  not parallelism; while workers are a means of both concurrency and  parallelism.



### Shared State

**Using Workers**

- `preload_app`: https://stackoverflow.com/questions/18213619/sharing-a-lock-between-gunicorn-workers
- https://stackoverflow.com/questions/57734298/how-can-i-provide-shared-state-to-my-flask-app-with-multiple-workers-without-dep

**Using Coroutines**



- When you use gevent, eventlet or other  coroutine frameworks there is a single process, there are no parent and  children. At the start of the process you can load or generate any data  you need and put it in the global scope, and that will be accessible to  all your handlers, because they all run in the same process. Since the  data is static (at least in this question it is) you don't even have to  worry about locking.
- Gunicorn can work with [gevent](http://www.gevent.org/) to create a server that can support multiple clients within a single worker process using coroutines



#### Example: `multiprocessing` worker

- e.g. when using `workers`

```python
from multiprocessing import Lock
from multiprocessing.managers import BaseManager

class SharedState:
    def __init__(self, address, authkey):
        self._data = {}
        self._lock = Lock()
        self._manager = BaseManager(address, authkey)
        self._manager.register('get', self._get)
        self._manager.register('set', self._set)
        try:
            self._manager.get_server()
            self._manager.start()
        except OSError: # Address already in use
            self._manager.connect()
    def __getattr__(self, name):
        if name.startswith('_'):
            return object.__getattr__(self, name)
        return self._manager.get(name)._getvalue()
    def __setattr__(self, name, value):
        if name.startswith('_'):
            return object.__setattr__(self, name, value)
        return self._manager.set(name, value)
    def _get(self, name):
        return self._data[name]
    def _set(self, name, value):
        with self._lock:
            self._data[name] = value
```



Example server:

- works with any number of workers, e.g. `gunicorn -w 4 server:app`

```python
from flask import Flask
app = Flask(__name__)

ADDRESS = '127.0.0.1', 35791
AUTHKEY = b'secret'
ss = SharedState(ADDRESS, AUTHKEY)
ss.number = 0

@app.route('/')
def counter():
    ss.number += 1
    return str(ss.number)
```









## Identifying Bottlenecks



**CPU bound workload**

- When we have CPU bound workload, thread based approaches (such as 
  greenlets) are not going to work because there is nobody to delegate the
  work for. What handles the client, also handles the computation and it 
  is fundamentally wrong.





## Use Case Examples

**Case Studies**

- [Long Computations over REST](https://medium.com/@grzegorzolechwierowicz/long-computations-over-rest-http-in-python-4569b1187e80)
- [Asynchronous Tasks with Flask and Redis Queue](https://testdriven.io/blog/asynchronous-tasks-with-flask-and-redis-queue/)

- [Redis and polling](https://realpython.com/flask-by-example-integrating-flask-and-angularjs/)
- [Example Redis queue with task status polling](https://testdriven.io/blog/asynchronous-tasks-with-flask-and-redis-queue/)





**Network bound Webapps**

- [NginX, gunicorn, flask](https://medium.com/@maheshkkumar/a-guide-to-deploying-machine-deep-learning-model-s-in-production-e497fd4b734a)
  - common state?
  - when to scale?



**CPU bound Webapps**

- [Flask-SocketIO, Celery](https://github.com/poonesh/Flask-SocketIO-Celery-example)
- [Flask, Redis, Celery on Docker](https://nickjanetakis.com/blog/dockerize-a-flask-celery-and-redis-application-with-docker-compose)

