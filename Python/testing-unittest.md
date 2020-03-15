# unittest - Testing Framework



## Structuring Tests

### Test Structure

```python
import unittest

class TestStringMethods(unittest.TestCase):
    def test_upper(self):
        self.assertEqual('foo'.upper(), 'FOO')

    def test_isupper(self):
        self.assertTrue('FOO'.isupper())
        self.assertFalse('Foo'.isupper())

if __name__ == '__main__':
    unittest.main()
```

**Setup/Teardown Routines**

- run on every test

```python
import unittest

class TestStringMethods(unittest.TestCase):
    def setUp(self):
        self.widget = Widget('The widget')

    def tearDown(self):
        self.widget.dispose()
```

### Grouping Tests

- tests classes can be imported and joined to a `unittest.TestSuite`



```python
import unittest

class WidgetTestCase(unittest.TestCase):
    def setUp(self):
        self.widget = Widget('The widget')

    def tearDown(self):
        self.widget.dispose()
```



```python
def suite():
    suite = unittest.TestSuite()
    suite.addTest(WidgetTestCase('test_default_widget_size'))
    suite.addTest(WidgetTestCase('test_widget_resize'))
    return suite

if __name__ == '__main__':
    runner = unittest.TextTestRunner()
    runner.run(suite())
```



## Running Tests

- `python -m unittest`
  - `-v` verbose

Selecting modules:

```
python -m unittest test_module1 test_module2
python -m unittest test_module.TestClass
python -m unittest test_module.TestClass.test_method
```



## Custom Assertions

- inverted methods: `.assertIsNot<...>`

| Method                    | Equivalent to      |
| ------------------------- | ------------------ |
| `.assertEqual(a, b)`      | `a == b`           |
| `.assertTrue(x)`          | `bool(x) is True`  |
| `.assertFalse(x)`         | `bool(x) is False` |
| `.assertIs(a, b)`         | `a is b`           |
| `.assertIsNone(x)`        | `x is None`        |
| `.assertIn(a, b)`         | `a in b`           |
| `.assertIsInstance(a, b)` | `isinstance(a, b)` |



## Mocking / Monkey Patching

- creates attributes and method when you access them (lazy attributes and methods)
- return values of mocks are also mocks
- https://realpython.com/python-mock-library/

```python
import mock
import unittest
```



### The Mock Class

```python
from unittest.mock import Mock
json = Mock()
```

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



### Patch()

- looks up an object in a given module and replaces that object with a `Mock`



**Mocking Classes**

```python
def some_function():
    instance = module.Foo()
    return instance.some_method()


with patch('module.Foo') as mock:
    instance = mock.return_value
    # patch the return value of the "some_method" function
    instance.some_method.return_value = 'the result'
    # call the function with the mocked class
    result = some_function()
    assert result == 'the result'
```





## Disabling Tests



```python
class MyTestCase(unittest.TestCase):

    @unittest.skip("demonstrating skipping")
    def test_nothing(self):
        self.fail("shouldn't happen")
```