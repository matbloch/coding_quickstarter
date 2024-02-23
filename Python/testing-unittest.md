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

**Mocking Methods**

```python
do_something = Mock()
do_something.return_value = 123
assert do_something()
```

**Mocking Properties**

```python
wrapper = Mock()
wrapper.return_value.a = 123
wrapper.return_value.b = 456
```



**Testing multiple function calls**

```python
mocked = mocker.path("MyClass.method")
expected_calls = [mocked.call(1,2,3), mocked.call("second-arg")]
mocked.assert_has_calls(expected_calls, any_order=True)
```



**asserting function calls on mocked classes**

```python
class MyClass():
  # ...
  def call_this(a, b, c):
    pass


def my_fn():
  instance = MyClass()
  instance.call_this(1, 2, 3)

def test_my_fn():
  mocked_cls = mocker.patch("MyClass")
  # get a link to the mocked instance
  mocked_cls_instance = mocked_class.return_value
  mocked_cls_instance.call_this.called_once_with(1, 2, 3)
```



**Triggering Side Effects / Exceptions**

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





**Resetting a Mock**

```python
mock.reset_mock()
```



### Patch()

> Patch works by (temporarily) changing the object that a name points to with another one. The basic principle is that you **patch where an object is looked up**,  which is not necessarily the same place as where it is defined.

- looks up an object in a given module and replaces that object with a `Mock`
- `from unittest.mock import patch`



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



**Mocking properties**

```python
# The function to test
p = subprocess.Popen(...)
if p.returncode is 0:
   pass # do something

# the mock
mock = patch('subprocess.Popen')
mock.return_value.returncode = 0
```



**Patching through the context manager**

```python
with patch('module.Foo') as mock:
    pass
```



**Patching through fixtures**

```python
@patch('os.path')
@patch('my_custom_module.fetch', return_value="my-mocked-return-value")
def test_single_model_prediction(mocked_fetch, _):
    mocked_fetch.return_value = True
    assert mocked_fetch()
```





## Disabling Tests



```python
class MyTestCase(unittest.TestCase):

    @unittest.skip("demonstrating skipping")
    def test_nothing(self):
        self.fail("shouldn't happen")
```