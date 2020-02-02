# unittest - Testing Framework





## Mocking

- https://realpython.com/python-mock-library/



```python
import mock
import unittest


```

- creates attributes and method when you access them (lazy attributes and methods)
- return values of mocks are also mocks



### Assertions and Inspections



- `<Mock name='yourMock>'`



**Definition**

```python
from unittest.mock import Mock
json = Mock()
```

Call some lazy methods/attributes

```python
json.loads('{"key": "value"}')
```





**Assertions**

```python
json.loads.assert_called()
json.loads.assert_called_once()
json.loads.assert_called_with('{"key": "value"}')
json.loads.assert_called_once_with('{"key": "value"}')
json.loads.assert_called_with(s='{"key": "value"}')
```

**Inspections**

```python
json.loads.call_count
json.loads.call_args
json.loads.call_args_list
json.method_calls
```

**Controlling return values**

```python
do_something = Mock()
do_something.return_value = 123
assert do_something()
```

**Side Effects**

- function called when mock is called or iterable or exception

```python
mock = Mock()
mock.side_effect = Exception('Boom!')
mock()	# raises Exception: Boom!
```

Example: Trigger timeout

```python
def get_holidays():
    r = requests.get('http://localhost/api/holidays')
    if r.status_code == 200:
        return r.json()
    return None

requests = Mock()
class TestCalendar(unittest.TestCase):
    def test_get_holidays_timeout(self):
        # Test a connection timeout
        requests.get.side_effect = Timeout
        with self.assertRaises(Timeout):
            get_holidays()
```

