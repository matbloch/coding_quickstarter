

# Factory Boy







**ORM Integration**

Integration with Object Relational Mapping tools is provided through specific `factory.Factory` sublasses:

- Django, with `factory.django.DjangoModelFactory`
- Mogo, with `factory.mogo.MogoFactory`
- MongoEngine, with `factory.mongoengine.MongoEngineFactory`
- SQLAlchemy, with `factory.alchemy.SQLAlchemyModelFactory`



## Factory Definition



### Examples

**Example:** SQLAlchemy Integration

```python
from sqlalchemy import Column, Integer, Unicode, create_engine
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import scoped_session, sessionmaker

engine = create_engine('sqlite://')
session = scoped_session(sessionmaker(bind=engine))
Base = declarative_base()

# --------- Model definition
class User(Base):
    """ A SQLAlchemy simple model class who represents a user """
    __tablename__ = 'UserTable'

    id = Column(Integer(), primary_key=True)
    name = Column(Unicode(20))

Base.metadata.create_all(engine)

# --------- Factory definition
import factory

class UserFactory(factory.alchemy.SQLAlchemyModelFactory):
    class Meta:
        model = User
        sqlalchemy_session = session   # the SQLAlchemy session object

    id = factory.Sequence(lambda n: n)
    name = factory.Sequence(lambda n: u'User %d' % n)
```

**Example:** Integration Option A

```python
class UserModel(Base):
    __tablename__ = 'account'
    id = Column(BigInteger, primary_key=True)
    name = Column(String, nullable=False)
    email = Column(String, nullable=False)

class UserFactory(factory.alchemy.SQLAlchemyModelFactory):
    id = factory.Sequence(lambda n: '%s' % n)
    name = factory.Faker('name')
    email = factory.Faker('email')

    class Meta:
        model = UserModel
```

```python
pytest.fixture(scope='function')
def session(connection):
    transaction = connection.begin()
    session = Session(bind=connection)
    # binding the SQLAlchemy session to the factory
    UserFactory._meta.sqlalchemy_session = session
    yield session
    session.close()
    transaction.rollback()
    
def my_func_to_delete_user(session, user_id):
    session.query(UserModel).filter(UserModel.id == user_id).delete()

def test_case(session):
    user = UserFactory.create()
    assert session.query(UserModel).one()
    my_func_to_delete_user(session, user.id)
    result = session.query(UserModel).one_or_none()
```

**Example:** Integration Option B

```python
from factory.alchemy import SQLAlchemyModelFactory
from api.extensions import db

from api.models import Teacher
import factory


class ModelFactory(SQLAlchemyModelFactory):
    """Base model factory."""
    class Meta:
        abstract = True
        sqlalchemy_session = db.session


class TeacherFactory(ModelFactory):
    id = factory.Sequence(lambda n: '%s' % n)
    name = factory.Faker('name')
    email = factory.Faker('email')

    class Meta:
        model = Teacher
```



## One-to-Many Relationships



**Factory Field Definition**

```python
class Group(Base):
    id = Column(Integer, autoincrement=True, primary_key=True)
    name = Column(String)

class Person(Base):
    id = Column(Integer, autoincrement=True, primary_key=True)
    group_id = Column(ForeignKey(Group.id))
    group = relationship(Group)

class PersonFactory(SQLAlchemyModelFactory):
    group = factory.SubFactory(GroupFactory)
    # ....
```

**Factory Implementation**

```python

```



## Content Generation

### Faker

- `factory.Faker()`

- Wrapper around *Faker*, see [documentation](https://faker.readthedocs.io/en/latest/)
- Provides realistic placeholder data

```python
class PersonFactory(SQLAlchemyModelFactory):
    name = factory.Faker('name', locale='de_DE')
    smiley = factory.Faker('smiley')
    address = factory.Faker('address')
    phone = factory.Faker('phone_number')
    
    
    first_name = 'Joe'
    last_name = 'Blow'
    email = factory.LazyAttribute(lambda a: '{0}.{1}@example.com'.format(a.first_name, a.last_name).lower())
```

### Dummy Content

```python
class PersonFactory(SQLAlchemyModelFactory):
    
    last_name = 'Blow'
    first_name = factory.Sequence(lambda n: "Agent %03d" % n)
    
    
    email = factory.LazyAttribute(lambda a: '{0}.{1}@example.com'.format(a.first_name, a.last_name).lower())
    email = factory.Sequence(lambda n: 'person{0}@example.com'.format(n))
```



## Modeling Relationship

**From populated tables**

- will only be called on first call to factory method

```python
import factory, factory.django
from . import models

class UserFactory(SQLAlchemyModelFactory):
    class Meta:
        model = models.User

    language = factory.Iterator(models.Language.query.all())
```

### Dependent Content

**ForeignKey**

- use `factory.SubFactory` declaration
- generated **before** base factory

Database model:

```python
class User(models.Model):
    group = models.ForeignKey(Group)
```

Factory:

```python
class UserFactory(SQLAlchemyModelFactory):
    class Meta:
        model = UserModel
    group = factory.SubFactory(GroupFactory)
```

**Reverse ForeignKey**

- generated **after** base factory

Database model:

```python
class User(models.Model):
    pass

class UserLog(models.Model):
    user = models.ForeignKey(User)
```

Factory:

```python
class UserFactory(SQLAlchemyModelFactory):
    class Meta:
        model = models.User

    log = factory.RelatedFactory(UserLogFactory, 'user', action=models.UserLog.ACTION_CREATE)
```

### Many-to-Many Relationship

**Many-to-many relationships**

- use `@factory.post_generation`

Database model:

```python
class Group(models.Model):
    name = models.CharField()

class User(models.Model):
    name = models.CharField()
    groups = models.ManyToManyField(Group)
```

Factories:

```python
class GroupFactory(SQLAlchemyModelFactory):
    class Meta:
        model = GroupModel
    name = factory.Sequence(lambda n: "Group #%s" % n)
    
    
class UserFactory(SQLAlchemyModelFactory):
    class Meta:
        model = UserModel

    @factory.post_generation
    def groups(self, create, extracted, **kwargs):
        if not create:
            # Simple build, do nothing.
            return

        if extracted:
            # A list of groups were passed in, use them
            for group in extracted:
                self.groups.add(group)
```

Using the factory

- No group: `UserFactory()` or `UserFactory.build()`
- Bind groups: `UserFactory.create(groups=(group1, group2, group3))`

**Simplified Many-to-Many Factory**

```python
class PersonFactory(factory.alchemy.SQLAlchemyFactory):
    class Meta:
        model = Person

    @factory.post_generation
    def addresses(obj, create, extracted, **kwargs):
        if not create:
            return

        if extracted:
            assert isinstance(extracted, int)
            AddressFactory.create_batch(size=extracted, person_id=self.id, **kwargs)
```

Usage

- `PersonFactory(addresses=4)` Create person with 4 addresses
- `PersonFactory(addresses=2, addresses__city='London')` Create person with 2 addresses, set `city` field of address to "London"



## Using Factories

- `user = UserFactory.build(first_name='Joe')`
- `users = UserFactory.build_batch(10, first_name="Joe")`



