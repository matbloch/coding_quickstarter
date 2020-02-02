# Pytest

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

