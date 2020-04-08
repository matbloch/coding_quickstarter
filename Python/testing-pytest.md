# Pytest

[Tutorial](https://www.guru99.com/pytest-tutorial.html)

- tests can be free functions
- `pytest ` automatically discovers test by naming  (see "Test Discovery")
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



## Test Discover and Import Mechanisms

**Test Discover Rules**

- Recurses through directories and finds `test_*.py` or `*_test.py` files. From those, the following methods are being executed:
  - `test` prefixed methods outside of a class
  - Methods of `Test` prefixed classes without an `__init__` method



### Import Rules and Invoking Pytest

**Calling pytest directly:**  `pytest [...]`

1. Search for test files

2. Include  path (added to `sys.path`) : Move up the directory tree and stop at the last folder containing a `__init__.py` file

   > **NOTE:** The test directory **should NOT** have same names as imported packages. This will lead to conflicts (everything is imported into the global namespace).

**Calling pytest as a module:** `python -m pytest [...]`

- Same as running `pytest` directy but current path will be added to `sys.path`



### Shared Test Functionality/Data

**conftest.py**

- `conftest.py` is automatically imported. Data can e.g. be shared through fixtures.
- can be local per directory

**Sharing test data**

- Plugins: `pytest-datadir`, `pytest-datafiles`



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



## Configuration Files

- `pytest.ini` primary pytest configuration file. Allows to change default behaviour.
- `conftest.py` local plugin to define hooks, fixtures in specific test (sub-)directories
- `__ini__.py`







## 3rd Party: Code Coverage

- `pytest-conv`

**Measuring Coverage**

`pytest --cov /tests/`



**Configuration File**

- `.coveragerc`

```ini
[run]
omit = venv/*
```










## Pytest Configuration File

- `pytest.ini`
- Allows to specify default command line arguments when running `pytest`



```python
[pytest]
addopts = -ra -q
```



## Test Marking

**Declare markers in `pytest.ini`**

```ini
[pytest]
markers =
    slow: marks tests as slow (deselect with '-m "not slow"')
```

**Use `@pytest.mark` Decorator**

```python
@pytest.mark.slow
def test_something_very_slow():
    # Do a very long test
    pass
```









## Testing with Specific Libraries



### pytest-flask

- define fixture that returns instance of app
- pass fixture as function argument `client` to test



Route definition

```python
@app.route('/user/<username>')
def show_user_profile(username):
    # show the user profile for that user
    return 'User %s' % escape(username)
```

Testing

```python
import pytest
from example_app import create_app

@pytest.fixture
def app():
    app = create_app()
    return app

# testing through application test client
def test_request(client):
    response = client.get("/user/MyName")
    assert response.status_code == 200
   

def test_request_method(client):
    response = show_user_profile("myUsername")
    
    

```





