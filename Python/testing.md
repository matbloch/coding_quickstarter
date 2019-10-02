# Testing in Python

**Resources**

- [!to summarize!](https://realpython.com/python-testing/#testing-for-web-frameworks-like-django-and-flask)



## Unit Testing

**Test runners:**

- unittest
- pytest (recommended)
- Nose/nose2



### Unittest

```python
import unittest

class TestStringMethods(unittest.TestCase):
    def test_upper(self):
        self.assertEqual('foo'.upper(), 'FOO')

    def test_isupper(self):
        self.assertTrue('FOO'.isupper())
        self.assertFalse('Foo'.isupper())

    def test_split(self):
        s = 'hello world'
        self.assertEqual(s.split(), ['hello', 'world'])
        # check that s.split fails when the separator is not a string
        with self.assertRaises(TypeError):
            s.split(2)
            
if __name__ == '__main__':
    unittest.main()
```



### Pytest

[Tutorial](https://www.guru99.com/pytest-tutorial.html)

```python
def test_sum():
    assert sum([1, 2, 3]) == 6, "Should be 6"

def test_sum_tuple():
    assert sum((1, 2, 2)) == 6, "Should be 6"
```



**Fixtures**

