# Flask SQL-Alchemy



[TOC]

## Integration

- See also [Integration Pattern Overview](http://flask.pocoo.org/docs/1.0/patterns/sqlalchemy/)



#### Option 1: `flask_sqlalchemy`

```python
from flask import Flask
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:////tmp/test.db'
db = SQLAlchemy(app
```

#### Option 2: Declarative

```python
from sqlalchemy import create_engine
from sqlalchemy.orm import scoped_session, sessionmaker
from sqlalchemy.ext.declarative import declarative_base

engine = create_engine('sqlite:////tmp/test.db', convert_unicode=True)
db_session = scoped_session(sessionmaker(autocommit=False,
                                         autoflush=False,
                                         bind=engine))
Base = declarative_base()
Base.query = db_session.query_property()
```



## Model Definition

```python
class ModelName(db.Model):
    __tablename__ = 'my_model'
    id = Column(integer, primary_key=True, auto_increment=True)
    name = Column(String)
    
    def __init__(self, a):
        	self.name = a
```



**`db.Column` Options**

 - `primary_key` Bool
 - `unique` Bool
 - `nullable` Bool
 - `autoincrement` Bool

**Datatypes**

- `db.Integer`
- `db.Float` 
- `db.String({length})`
- `db.DateTime`
  - `db.Column(db.DateTime, auto_now_add=True)`
- `db.Boolean`

**Initialization**



### Base Class

Augmenting the base class allows to e.g. create the same base columns for all models.

```python
from sqlalchemy.ext.declarative import declared_attr

class Base(object):
    @declared_attr
    def __tablename__(cls):
        return cls.__name__.lower()

    __table_args__ = {'mysql_engine': 'InnoDB'}

    id =  Column(Integer, primary_key=True)

from sqlalchemy.ext.declarative import declarative_base

Base = declarative_base(cls=Base)

class MyModel(Base):
    name = Column(String(1000))
```

### Mixins

Mixing classes inherit in addition to the primary base (preferred to base extension).





## Inheritance

- Inheritance is controlled by `polymorphic_*` keywords defined on ``__mapper_args__``  property

### Multiple Tables

- subclass that defines it's own table

```python
class Person(Base):
    __tablename__ = 'people'
    id = Column(Integer, primary_key=True)
    discriminator = Column('type', String(50))
    __mapper_args__ = {'polymorphic_on': discriminator}

class Engineer(Person):
    __tablename__ = 'engineers'
    __mapper_args__ = {'polymorphic_identity': 'engineer'}
    id = Column(Integer, ForeignKey('people.id'), primary_key=True)
    primary_language = Column(String(50))
```



### Single Table Inheritance

- no `__tablename__` defined in child class

```python
class Person(Base):
    __tablename__ = 'people'
    id = Column(Integer, primary_key=True)
    discriminator = Column('type', String(50))
    __mapper_args__ = {'polymorphic_on': discriminator}

class Engineer(Person):
    __mapper_args__ = {'polymorphic_identity': 'engineer'}
    primary_language = Column(String(50))
```



## Data Relationships

Patterns:

- Foreign-Key: Value should be constrained to primary key of other table
- Relationship: ORM pattern to link classes



### 1-to-Many Relationships

![1-to-many](img\1-to-many.png)

- `db.relationship`, defined in the **one** structure
	- `lazy` Bool - Default: load data in one go using a standard select statement
	- `backref` String - create property of this model in linked models
	- (`back_populates` String - alternative to `backref` where link in other object is not automatically created)
	- `uselist` Bool - set to `False` if its a 1-to-1 relationship
- `db.ForeignKey` separately defined key (on the **many** side) that refers to other model


```python
class User(db.Model):
    id =  db.Column(db.Integer, primary_key=True)
    posts = db.relationship('Post', backref='user', lazy=True)
class Post(db.Model):
	user_id = db.Column(db.Integer, db.ForeignKey(user.id)), nullable=False)
```

**Relationship Queries**

```python
u = User.query.get(1)
posts = u.posts.all()
```

### 1-to-1 Relationships

- `db.relationship(uselist=False)`

```python
class Person(Base):
    __tablename__ = 'people'
    id = Column(Integer, primary_key=True)
    mobile_phone = relationship("MobilePhone", uselist=False, backref=backref("person"))
class MobilePhone(Base):
    __tablename__ = 'mobile_phones'
    id = Column(Integer, primary_key=True)
    person_id = Column(Integer, ForeignKey('people.id'))
```

### Many-to-Many Relationships

![many-to-many](img\many-to-many.png)

- needs association table

```python
student_teacher = db.Table('student_teacher',
    db.Column('student_id', db.Integer, db.ForeignKey('student.id'), primary_key=True),
    db.Column('teacher_id', db.Integer, db.ForeignKey('teacher.id'), primary_key=True)
)
```

**Models**

```python
class Student(db.Model):
    teachers = db.relationship(
    	'Teacher'
        secondary=student_teacher,
        lazy='subquery'
        backref=db.backref('students')
    )
    
class Teacher(db.Model):
    id = db.Column(db.Integer, primary_key=True)
```

**Association Table**

```python
followers = db.Table('followers',
    db.Column('follower_id', db.Integer, db.ForeignKey('user.id')),
    db.Column('followed_id', db.Integer, db.ForeignKey('user.id'))
)
```



### Association Object

The association object pattern is a variant on many-to-many: it’s used when your association table contains additional columns beyond those which are foreign keys to the left and right tables. 

- see [doocumentation](https://docs.sqlalchemy.org/en/13/orm/basic_relationships.html#association-object)



----------

### Additional Configurations

#### Required/Nullable Relationships

Add `nullable` to *"many"* side in case the object can exist without assignment

```python
class Person(Base):
    __tablename__ = 'people'
    id = Column(Integer, primary_key=True)
    todos = relationship("Todo", backref=backref("person"))
    
class Todo(Base):
    __tablename__ = 'todos'
    id = Column(Integer, primary_key=True)
    person_id = Column(Integer, ForeignKey('people.id'), nullable=True)
```





#### Subset Relationships

- `primaryjoin`
- Only link a specific subset

```python

class User(Base):
    __tablename__ = 'user'
    id = Column(Integer, primary_key=True)
    name = Column(String)
    boston_addresses = relationship("Address",
                    primaryjoin="and_(User.id==Address.user_id, "
                        "Address.city=='Boston')")

class Address(Base):
    __tablename__ = 'address'
    id = Column(Integer, primary_key=True)
    user_id = Column(Integer, ForeignKey('user.id'))
    city = Column(String)
```

#### ORM Cascade

- Determines how changes from the parent (the class that defines the relationship) are propagated to child objects

- configurable behavior for `relationship` construct

```python
class Order(Base):
    # define cascade on a relationship
    items = relationship("Item", cascade="all, delete-orphan")
    customer = relationship("User", cascade="save-update")
    # define cascade on a backref
    products = relationship("Product", backref=backref("products", cascade="all, delete-orphan"))
```

**Available Options**

- `save-update`: all objects associated with `relationship` will be added to session on `session.add`
- `delete` if parent is marked for deletion, child should also be deleted
  - ORM vs "FOREIGN KEY" cascade: use either
  - many-to-many: `secondary` many-to-many table entries are updated automatically
- `relationship()` or `FOREIGN KEY` constraint to 
- `delete-orphan` deleted if de-associated from parent

**Defaults:**

- `all`: `save-update, merge, refresh-expire, expunge, delete`
- default value: `save-update, merge`
- common: `all, delete-orphan`

**Example: `save-update`**

- automatically adds child relationships to session

```python
user1 = User()
address1, address2 = Address(), Address()
user1.addresses = [address1, address2]
sess = Session()
sess.add(user)
# address 1 and 2 also added to session
```

#### Foreign-Key Cascade

```python
class Address(Base):
    __tablename__ = 'address'
    id = Column(Integer, primary_key=True)
    user_id = Column(Integer, ForeignKey('user.id'), 
                     onupdate="CASCADE", ondelete="CASCADE"), primary_key=True)
```

- `onupdate="CASCADE"`: updates this field when other key is updated

- `ondelete="CASCADE"`: deletes this instance if other item is deleted



## Hybrid Attributes

- `@hybrid_property`

```python
class Interval(Base):
    __tablename__ = 'interval'

    id = Column(Integer, primary_key=True)
    start = Column(Integer, nullable=False)
    end = Column(Integer, nullable=False)
    
    def __init__(self, start, end):
        self.start = start
        self.end = end
    @hybrid_property
    def length(self):
        return self.end - self.start
```

**Hybrid Attributes for querying**

- `@{hybrid_property}.expression`

- **Note**: use sqlalchemy `abs` for SQL function

```python
from sqlalchemy import func

class Interval(object):
    # ...
    @hybrid_property
    def radius(self):
        return abs(self.length) / 2

    @radius.expression
    def radius(cls):
        return func.abs(cls.length) / 2
```

- `Session().query(Interval).filter(Interval.radius > 5)`



## Setters

```python
class Interval(object):
    # ...

    @hybrid_property
    def length(self):
        return self.end - self.start
    @length.setter
    def length(self, value):
        self.end = self.start + value
```

- `interval = Interval(5, 10)`
- `interval.length = 12`



## Object Manipulation

**Insert**

- `db.session.add({Object})`

```python
admin = User(username='admin', email='admin@admin.com')
db.session.add(admin)
db.session.commit()
```

**Read**

- `{Object}.query`

```python
users = User.query.all()
```

**Update**

- `db.session.update({Object})`

```python
admin.username = "another_name"
db.session.update(admin)
db.session.commit()
```

**Deletion**

- `db.session.delete({Object})`

```python
users = User.query.all().delete()
db.session.commit()
```

**Adding/Removing Relationships**

1-to-many:
```python
a = Address(email='foo@bar.com')
p = Person(name='foo')
p.addresses.append(a)
```
```python
a = Address(email='foo@bar.com')
p = Person(name='foo', addresses=[a])
```

many-to-many:

```python
my_day.players.add(my_player) #Adds
my_day.players.remove(my_player) #Remove
```



### Bulk Operations

**Saving**

```python
session.bulk_save_objects(objects)
session.commit()
```



# Query API

- `session.query(User)` or `User.query`

**filtering**

- `User.query.all()` query all
- `User.query.filter_by(username='admin').first()` search by column
- `User.query.filter(User.email.endswith('@example.com')).all()`

**Ordering**

- `User.query.order_by(User.username.desc()).all()`

**Limiting**

- `User.query.first()`
- `User.query.limit(1).all()`



- `count()`: Returns the total number of rows of a query.
- `filter()`: Filters the query by applying a criteria.
- `delete()`: Removes from the database the rows matched by a query.
- `distinct()`: Applies a [distinct statement](https://www.w3schools.com/sql/sql_distinct.asp) to a query.
- `exists()`: Adds an [exists operator](https://www.w3schools.com/sql/sql_exists.asp) to a subquery.
- `first()`: Returns the first row in a query.
- `get()`: Returns the row referenced by the primary key parameter passed as argument.
- `join()`: Creates a [SQL join](https://www.w3schools.com/sql/sql_join.asp) in a query.
- `limit()`: Limits the number of rows returned by a query.
- `order_by()`: Sets an order in the rows returned by a query.

**Examples**

```python
# 1 - imports
from datetime import date

# other imports and sections...

# 5 - get movies after 15-01-01
movies = session.query(Movie) \
    .filter(Movie.release_date > date(2015, 1, 1)) \
    .all()

print('### Recent movies:')
for movie in movies:
    print(f'{movie.title} was released after 2015')
print('')

# 6 - movies that Dwayne Johnson participated
the_rock_movies = session.query(Movie) \
    .join(Actor, Movie.actors) \
    .filter(Actor.name == 'Dwayne Johnson') \
    .all()

print('### Dwayne Johnson movies:')
for movie in the_rock_movies:
    print(f'The Rock starred in {movie.title}')
print('')

# 7 - get actors that have house in Glendale
glendale_stars = session.query(Actor) \
    .join(ContactDetails) \
    .filter(ContactDetails.address.ilike('%glendale%')) \
    .all()

print('### Actors that live in Glendale:')
for actor in glendale_stars:
    print(f'{actor.name} has a house in Glendale')
print('')
```



### SQL Operators

**IN**

```python
session.query(MyUserClass).filter(MyUserClass.id.in_((123,456))).all()
```

**SELECT** - Query attributes

```python
session.query(Thing.id).all()
# [(1,), (2,), (3,), (4,)]
îds = [id for (id, ) in session.query(Customer.id).all()]
```

```python
result = SomeModel.query.with_entities(SomeModel.col1, SomeModel.col2)
```





# Examples



**Adding Relationships by ID**

```python
class Person(Base):
    __tablename__ = 'person'
    id      = Column(Integer, primary_key=True)
    name    = Column(String(50))


class SexyParty(Base):
    __tablename__ = 'sexy_party'
    id      = Column(Integer, primary_key=True)
    guests  = relationship('Person', secondary='guest_association',
                        lazy='dynamic', backref='parties')

guest_association = Table(
    'guest_association', Base.metadata,
    Column('user_id',       Integer(), ForeignKey('person.id'), primary_key=True),
    Column('sexyparty_id',  Integer(), ForeignKey('sexy_party.id'), primary_key=True)
)

from sqlalchemy.ext.associationproxy import association_proxy

class GuestAssociation(Base):
    __table__ = guest_association
    party = relationship("SexyParty", backref="association_recs")

SexyParty.association_ids = association_proxy(
                    "association_recs", "user_id",
                    creator=lambda uid: GuestAssociation(user_id=uid))

sp1 = SexyParty(id=1)
sp1.association_ids.extend([3, 4])
session.commit()

```

