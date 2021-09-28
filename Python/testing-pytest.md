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



## Temporary Files and Folders

#### Temporary Files

```python
fp = tempfile.TemporaryFile()
fp.write(b'Hello world!')
# closing the file will remove it
fp.close()
```

**Using a context manager**

```python
with tempfile.TemporaryFile() as fp:
  	fp.write(b'Hello world!')
```

**Named files**

```python
with tempfile.NamedTemporaryFile() as fp:
  print(f"File name: {fp.name}")
```



**Example:** Dumping content to temporary files

```python
@contextmanager
def dump_to_json(data: dict) -> ContextManager[str]:
    """
    Dumps provided data dictionary to a temporary json file
    :param data: The data to serialize as json
    :return: The absolute path to the temporary json file
    """
    fp = tempfile.NamedTemporaryFile(mode='w+')
    json.dump(data, fp)
    fp.seek(0)
    assert os.stat(fp.name).st_size > 0
    try:
        yield fp.name
    finally:
        fp.close()
        
with dump_to_json({"key": 123}) as abs_file_path:
    do_something(abs_file_path)
```



#### Temporary Folders

```python
with tempfile.TemporaryDirectory() as tmpdirname:
		print('created temporary directory', tmpdirname)
```



**Nested folders**

```python
import os
os.makedirs(os.path.join(tempdir, 'nested_dir'))
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



#### Parametrized Fixtures

**Single Parameter**

Fixture definition:

```python
@pytest.fixture()
def resource(resource_name):
    return {"name": resource_name}
```

Usage:

```python
@pytest.mark.parametrize("resource_name", ["My Custom Resource"])
def test_this(resource, resource_name):
    print(resource_name)
```

**Multiple Parameters**

```python
@pytest.fixture()
def resource(resource_name, resource_value):
    return {"name": resource_name, "value": resource_value}
```

**NOTE:** Multiple parameters have do be declared inside a comma separated string

```python
@pytest.mark.parametrize(
    "resource_name, resource_value", [("ResName1", "ResVal1"), ("ResName2", "ResVal2")]
)
def test_this(resource, resource_name, resource_value):
    print(resource_name)
    print(resource_value)
```



#### Modularizing Fixtures

**tests/fixtures/add.py**

- define fixture in separate file

```python
import pytest

@pytest.fixture
def add(x, y):
    x + y
```

**tests/conftest.py**

- import in conftest

```python
import pytest
from fixtures.add import add
```

**tests/adding_test.py**

```python
import pytest

@pytest.mark.usefixtures("add")
def test_adding(add):
    assert add(2, 3) == 5
```



#### Fixture Scopes

- `module` All methods in same file receive the same object instance



```python
@pytest.fixture(scope="module")
def smtp():
    # the returned fixture instance will only be shared for tests
    # inside a single module/file
  
  
@pytest.fixture(scope="session")
def smtp(...):
    # the returned fixture value will be shared for
    # all tests needing it
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



## Marks: Categorizing Tests

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

#### Predefined Marks

- `skip` skips a test unconditionally
- `skipif`  conditional skipping
- `xfail` indicates that a test is expected to fail
- `parametrize` create multiple variants of a test with different arguments (see section "Test Parametrization")



## Parametrization: Combining Tests

- `@pytest.mark.parametrize` to execute single test with a set of parameters

Desired test structure:

```python
def test_is_palindrome_<in some situation>():
    assert is_palindrome("<some string>")
```

**Example**: Parametrizing input data

```python
@pytest.mark.parametrize("palindrome", [
    "",
    "a",
    "Bob",
    "Never odd or even",
    "Do geese see God?",
])
def test_is_palindrome(palindrome):
    assert is_palindrome(palindrome)
```







## Testing Specific Libraries



### Flask

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

# define application in fixture
@pytest.fixture
def app():
    yield create_app("config.ProductionConfig")

@pytest.fixture
def client(app):
    return app.test_client()

def test_index(app, client):
    res = client.get('/')
    assert res.status_code == 200
    expected = {'hello': 'world'}
    assert expected == json.loads(res.get_data(as_text=True))

# testing through application test client which is passed as "client"
def test_request(client):
    response = client.get("/user/MyName")
    assert response.status_code == 200
   

def test_request_method(client):
    response = show_user_profile("myUsername")

```



**Headers**

```python
client.get('/auth/status', headers=dict(Authorization='Bearer abc'))
```

**Content**

```python
client.post(
    data=json.dumps(dict(email="joe@gmail.com", password="123456")),
    content_type="application/json",
)
```







### moto

- mocking of AWS services connected through boto3
- Multiple ways to mock services:
  - decorator: Automatic scoped mocking using the `@mock_<service>` decorator
  - context manager: Scoped mocking inside a context opened through `with` 
  - raw use: Manually instantiate and start the mock



**Example**: S3 bucket fixture

- context manager automatically calls `start` and `stop` on the moto service mock

```python
@pytest.fixture()
def moto_boto():
    with mock_s3():
        res = boto3.resource('s3')
        res.create_bucket(Bucket="my_bucket")
        yield

def test_with_fixture(moto_boto):
    client = boto3.client('s3')
    client.list_objects(Bucket=BUCKET)
```





### SQLAlchemy

conftest.py

````python
import pytest
from sqlalchemy.orm import Session
from sqlalchemy import create_engine

test_db_url = "sqlite://"  # use in-memory database for tests


@pytest.fixture(scope="session")
def engine():
    return create_engine(test_db_url)


# 'dbsession' fixture: Each test runs in a separate transaction with automatic cleanup
@pytest.fixture
def dbsession(engine):
    """Returns an sqlalchemy session, and after the test tears down everything properly."""
    connection = engine.connect()
    # begin the nested transaction
    transaction = connection.begin()
    # use the connection with the already started transaction
    session = Session(bind=connection)

    yield session

    session.close()
    # roll back the broader transaction
    transaction.rollback()
    # put back the connection to the connection pool
    connection.close()
````

Using the fixture:

```python
def test_database_connection(dbsession):
    # ...
    pass
```



