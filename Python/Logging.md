# Logging





### Default Logging Module

**Levels**

```python
import logging

logging.debug('This is a debug message')
logging.info('This is an info message')
logging.warning('This is a warning message')
logging.error('This is an error message')
logging.critical('This is a critical message')
```

**Configuration**

```python
import logging

logging.basicConfig(
    level=logging.DEBUG,
    format='%(asctime)s | %(name)s | %(levelname)s | %(message)s'
)
```



### Multiple Loggers

- default logger is named `root`
  - direct calls through `logging` , e.g. `logging.debug()` will use `root`



**Defining a logger**

```python
logger = logging.getLogger('example_logger')
logger.warning('This is a warning')
```







### Examples

**Configuring Stack Traces**

```python
import logging

a = 5
b = 0

try:
  c = a / b
except Exception as e:
  logging.error("Exception occurred", exc_info=True)
```