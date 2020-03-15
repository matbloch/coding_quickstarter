# Pytest

[Tutorial](https://www.guru99.com/pytest-tutorial.html)

- tests are free functions
- test files start with `test_` prefix
- pytest automatically discovers test by naming
- regular asserts can be use



**Minimal Test Setup**

```python
def test_sum():
    assert sum([1, 2, 3]) == 6, "Should be 6"

def test_sum_tuple():
    assert sum((1, 2, 2)) == 6, "Should be 6"
```

**Structuring Tests**

```
├── tests/
    ├── conftest.py
    ├── test_database.py
```



## Fixtures

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



## Monkey Patching

> Replacing / injecting custom functionality for testing purposes

```python
# contents of test_app.py, a simple test for our API retrieval
import pytest
import requests

# app.py that includes the get_json() function
import app

# custom class to be the mock return value of requests.get()
class MockResponse:
    @staticmethod
    def json():
        return {"mock_key": "mock_response"}


# monkeypatched requests.get moved to a fixture
@pytest.fixture
def mock_response(monkeypatch):
    """Requests.get() mocked to return {'mock_key':'mock_response'}."""

    def mock_get(*args, **kwargs):
        return MockResponse()

    monkeypatch.setattr(requests, "get", mock_get)


# notice our test uses the custom fixture instead of monkeypatch directly
def test_get_json(mock_response):
    result = app.get_json("https://fakeurl")
    assert result["mock_key"] == "mock_response"
```



## Mocking

> Testing calls to abstracted resource

- use `pytest-mock` (a thin wrapper around the `mock` library in `unittest`)
- introduces a fixture `mocker` that allows to mock structures
- See also [testing-pytest.md](testing-pytest.md) for the documentation of `mock`
- use `mocker.patch('your-function-name')`

**Example**

The actual implementation

```python
import os

class UnixFS:
    @staticmethod
    def rm(filename):
        os.remove(filename)
        
```

Testing by mocking file system components

```python
# use the fixture "mocker"
def test_unix_fs(mocker):
    # mock the "os.remove" method
    mocker.patch('os.remove')
    UnixFS.rm('file')
    # check that call was performed
    os.remove.assert_called_once_with('file')
```









## Testing Flask Applications

