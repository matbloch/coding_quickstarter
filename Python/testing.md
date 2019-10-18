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



## Pytest

[Tutorial](https://www.guru99.com/pytest-tutorial.html)

```python
def test_sum():
    assert sum([1, 2, 3]) == 6, "Should be 6"

def test_sum_tuple():
    assert sum((1, 2, 2)) == 6, "Should be 6"
```



- test files start with `test_` prefix



**Structuring Tests**

```
├── tests/
    ├── conftest.py
    ├── test_database.py
```





### Transactions

- Fundamental concept of all database systems
- Bundles multiple steps into a single, all-or-nothing operation

**Properties**

- **Atomic:** succeeded, or failed

- **Isolation:** ensures that transactions operated independently of of others; they are not visible till completed

  

### Fixtures

**Test Flow**

1. Begin transaction
2. Factories
3. Execute Logic
4. Assertions
5. Rollback transaction



**Fixture Definition**

conftest.py

```python
import pytest
from sqlalchemy.orm import sessionmaker
from sqlalchemy import create_engine

test_db_url = 'sqlite://'  # use in-memory database for tests
engine = create_engine(test_db_url)
Session = sessionmaker()

# 'connection' fixture: ensure that there's only a single db instance
@pytest.fixture(scope='module')
def connection():
    connection = engine.connect()
    yield connection
    connection.close()

# 'session' fixture: Each test runs in a separate transaction with automatic cleanup
@pytest.fixture(scope='function')
def session(connection):
    transaction = connection.begin()
    session = Session(bind=connection)
    yield session
    # Finalize test here
    session.close()
    transaction.rollback()
```



**Example test**

```python
def test_case(session):
    pass
```



### Testing Flask Applications





