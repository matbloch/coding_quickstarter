# Using Redis in Flask





```python
import redis
r = redis.Redis(url='redis://:[PASSWORD]@[HOSTNAME]:[PORT]/0')
# Setting a Value
r.set('foo', 'bar')
# Getting a Value
r.get('foo')
```



**Storing a structure**

```python
r.set('my_structure', json.dumps({'some': 123}))
my_structure = json.loads(r.get('my_structure'))
```

