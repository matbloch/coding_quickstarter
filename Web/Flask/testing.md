# Testing Flask Applications



**Requirements**

- Flask
- SQLAlchemy
- Pytest



**Project Structure**

- `/tests` contains all testing infrastructure
- `conftest.py` contains the fixture 
- `/../functional` functional/integration tests
- `/../unit` unit tests

```bash
.
├── main.py
├── project
├── requirements.txt
├── tests
│   ├── conftest.py
│   ├── functional
│   │   ├── __init__.py
│   │   └── test_users.py
│   ├── pytest.ini
│   └── unit
│       ├── __init__.py
│       └── test_models.py
└── venv
```



**Running the tests**

- `pytest tests/unit` 
  - `--setup-show` show the setup/teardown of the test



## Fixtures

- Usual testing framework structure (e.g. GTest): `Setup()` ... run the case ... `Teardown()`

- Fixtures run prior to each test case and can be defined per **scope**
- Returns instance of e.g. test data and returns it for test cases within the scope to use

- Setup/Teardown only **once** per scope

- `yield` 



**Fixture Structure**

```python
@pytest.fixture(scope='module')
def my_data_provider():
    # do setup
    return 123
```



**Unit Test**

- pass fixture names as arguments (multiple)

```python
def test_home_page(my_data_provider, my_other_fixture):
    result = do_something(my_data_provider)
    assert result == True
```



**Execution Example**





## Functional Tests

- test e.g. how a user can log in, and log out





#### Client Fixture

```python
@pytest.fixture(scope='module')
def test_client():
    flask_app = create_app('flask_test.cfg')
 
    # Flask provides a way to test your application by exposing the Werkzeug test Client
    # and handling the context locals for you.
    testing_client = flask_app.test_client()
 
    # Establish an application context before running the tests.
    ctx = flask_app.app_context()
    ctx.push()
 
    yield testing_client  # this is where the testing happens!
 
    ctx.pop()
```



#### Database Initialization Fixture

- creates database
- adds users
- after all tests are done, db is destroyed



```python
@pytest.fixture(scope='module')
def init_database():
    # Create the database and the database table
    db.create_all()
 
    # Insert user data
    user1 = User(email='patkennedy79@gmail.com',
                 plaintext_password='FlaskIsAwesome')
    user2 = User(email='kennedyfamilyrecipes@gmail.com', 
                 plaintext_password='PaSsWoRd')
    db.session.add(user1)
    db.session.add(user2)
 
    # Commit the changes for the users
    db.session.commit()
 
    yield db  # this is where the testing happens!
 
    db.drop_all()
```





### Examples

**Test Page Response**

```python
def test_home_page(test_client):
    response = test_client.get('/')
    assert response.status_code == 200
    assert b"Welcome to the Flask User Management Example!" in response.data
```

**Test User Login/Logout**

```python
def test_valid_login_logout(test_client, init_database):
    # post to login endpoint
    response = test_client.post('/login',
                                data=dict(email='patkennedy79@gmail.com', 
                                          password='FlaskIsAwesome'),
                                follow_redirects=True)
    assert response.status_code == 200
	# post to logout endpoint
    response = test_client.get('/logout', follow_redirects=True)
    assert response.status_code == 200
```







#### Example: Database Fixture

```python
import os
import tempfile

import pytest

from flaskr import flaskr


@pytest.fixture
def client():
    db_fd, flaskr.app.config['DATABASE'] = tempfile.mkstemp()
    flaskr.app.config['TESTING'] = True
    client = flaskr.app.test_client()

    with flaskr.app.app_context():
        flaskr.init_db()

    yield client

    os.close(db_fd)
    os.unlink(flaskr.app.config['DATABASE'])
```



## Unit Tests



#### Example: Testing Users

```python
import pytest
from project.models import User
 
 # create a user instance and return it for each test in the module scope
@pytest.fixture(scope='module')
def new_user():
    user = User('patkennedy79@gmail.com', 'FlaskIsAwesome')
    return user

def test_new_user(new_user):
    """
    GIVEN a User model
    WHEN a new User is created
    THEN check the email, hashed_password, authenticated, and role fields are 	 defined correctly
    """
    assert new_user.email == 'patkennedy79@gmail.com'
    assert new_user.hashed_password != 'FlaskIsAwesome'
    assert not new_user.authenticated
    assert new_user.role == 'user'
```



