# Keras





## Inference and Model Loading



### Running Multiple Models in parallel

**Create a new graph for each model:**

```python
graph1 = Graph()
with graph1.as_default():
    session1 = Session()
    with session1.as_default():
        with open('model1_arch.json') as arch_file:
            model1 = model_from_json(arch_file.read())
        model1.load_weights('model1_weights.h5')
        # K.get_session() is session1
```



### Multi-Threading

- graph and session needs to be defined globally
- `load_model` is executed when the module is imported
- `some_worker_function` will be executed in different threads
-  `model._make_predict_function() # have to initialize before threading` 

```python
from keras.models import load_model
import tensorflow as tf

MY_MODEL = load_model('path/to/model/file')
MY_GRAPH = tf.get_default_graph()

def some_worker_function(inputs):
    with MY_GRAPH.as_default():
        return MY_MODEL.predict(inputs)
```



### Executing With Celery

- Celery uses `Process`: New process is spawned for each worker:
  - New python interpreter instance
  - Global address space is **duplicated**

- See also [Stackoverflow](https://stackoverflow.com/questions/45459205/keras-predict-not-returning-inside-celery-task) for a workaround

https://stackoverflow.com/questions/45459205/keras-predict-not-returning-inside-celery-task





Alternative implementation to try out: https://stackoverflow.com/questions/41734275/no-response-from-celery-worker-with-tensorflow

- move all Keras related stuff to initializer function

```python
from celery import Celery
from celery.signals import worker_process_init

CELERY = ...

@worker_process_init.connect()
def init_worker_process(**kwargs):

    // Load all Keras related imports here
    import ...


@CELERY.task()
def long_running_task(*args, **kwargs):

    // Actual calculation task
    ...
```

