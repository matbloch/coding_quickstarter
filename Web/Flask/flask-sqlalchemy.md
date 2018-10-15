# Flask SQL-Alchemy





**Integration**

```python
from flask import Flask
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:////tmp/test.db'
db = SQLAlchemy(app)
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





`db.Column`

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





## Data Relationships

#### 1-to-Many Relationships

![1-to-many](img\1-to-many.png)

- `db.relationship`, defined in the **one** structure
	- `lazy` Bool - Default: load data in one go using a standard select statement
	- `backref`String - create property of this model in linked models
	- `uselist` Bool - set to `True` if its a 1-to-1 relationship
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



**1-to-1 Relationships**

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

#### Many-to-Many Relationships

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
users = User.query.all()
for u in users:
	db.session.delete(u)
```

**Adding Relationships**

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



## Query API

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





## ORM Cascade

- configurable behavior for `relationship` construct


```python
class Order(Base):
    items = relationship("Item", cascade="all, delete-orphan")
    customer = relationship("User", cascade="save-update")
```


**Cascades:**
- `save-update`: all objects associated with `relationship` will be added to session on `session.add`
- `delete` if parent is marked for deletion, child should also be deleted
	- ORM vs "FOREIGN KEY" cascade: either use
	- many-to-many: `secondary` many-to-many table entries are updated automatically
- `relationship()` or `FOREIGN KEY` constraint to 
- `delete-orphan` deleted if de-associated from parent

**Defaults:**
- `all`: `save-update, merge, refresh-expire, expunge, delete`
- default value: `save-update, merge`
- common: `all, delete-orphan`

