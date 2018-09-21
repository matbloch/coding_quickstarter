# Slick APIs: SQL-Alchemy & Marshmallow




**Model Definition** (SQL-Alchemy)

```python
class Author(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255))

class Book(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255))
    author_id = db.Column(db.Integer, db.ForeignKey('author.id'))
    author = db.relationship('Author', backref='books')
```




# Declaring Schemas

**Options**
- `required`
- `allow_none`
- `load_only`
- `dump_only` "read-only" skip field during

**Model Definition**
```python
import datetime as dt

class User(object):
    def __init__(self, name, email):
        self.name = name
        self.email = email
        self.created_at = dt.datetime.now()
```

**Output Schema**

```python
from marshmallow import Schema, fields
class UserSchema(Schema):
    name = fields.Str()
    email = fields.Email()
    created_at = fields.DateTime()
```



### Required Fields

```python
from marshmallow import ValidationError

class UserSchema(Schema):
    name = fields.String(required=True)
    age = fields.Integer(
        required=True,
        error_messages={'required': 'Age is required.'}
    )
    city = fields.String(
        required=True,
        error_messages={'required': {'message': 'City required', 'code': 400}}
    )
    email = fields.Email()
```

### Unknown Fields

- `unknown`
	- `INCLUDE` add unknown fields during `load`
	- `EXCLUDE` exclude unknown fields
	- `RAISE`

```python
from marshmallow import Schema, INCLUDE
class UserSchema(Schema):
    class Meta:
        unknown = INCLUDE
```

or

`UserSchema().load(data, unknown=INCLUDE)`


### Read-only/Write-only

```python
class UserSchema(Schema):
    name = fields.Str()
    # password is "write-only"
    password = fields.Str(load_only=True)
    # created_at is "read-only"
    created_at = fields.DateTime(dump_only=True)
```


### Nested Schemas
```python
class BlogSchema(Schema):
    title = fields.String()
    author = fields.Nested(UserSchema)
```

**Multiple objects**
```python
collaborators = fields.Nested(UserSchema, many=True)
```

**Select Nested Attributes**

```python
author = fields.Nested(UserSchema, only=["email"])
```

or when creating schema, using `.` delimiter:

```python
class SiteSchema(Schema):
    blog = fields.Nested(BlogSchema2)
schema = SiteSchema(only=['blog.author.email'])
```

**Two-Way Nesting**
- e.g. in many-to-one relationship
- make sure to use `only` or `exclude` to prevent loop

```python
class AuthorSchema(Schema):
    # Make sure to use the 'only' or 'exclude' params
    # to avoid infinite recursion
    books = fields.Nested('BookSchema', many=True, exclude=('author', ))
    class Meta:
        fields = ('id', 'name', 'books')

class BookSchema(Schema):
    author = fields.Nested(AuthorSchema, only=('id', 'name'))
    class Meta:
        fields = ('id', 'title', 'author')
```

**Nesting Schema withing itself**

```python
class UserSchema(Schema):
    name = fields.String()
    email = fields.Email()
    friends = fields.Nested('self', many=True)
    # Use the 'exclude' argument to avoid infinite recursion
    employer = fields.Nested('self', exclude=('employer', ), default=None)
```


### Validation




## Using the Schemas

### Serializing

**Serializing Objects: `dumping`**
- creates json/python dict from object
- `dump` serializes object to python dict
```python
user = User(name="Monty", email="monty@python.org")
schema = UserSchema()
result = schema.dump(user)
```

**Filtering Outputs**
```python
summary_schema = UserSchema(only=('name', 'email'))
summary_schema.dump(user)
```

**Collections of Objects**
- `many=True`
```python
user1 = User(name="Mick", email="mick@stones.com")
user2 = User(name="Keith", email="keith@stones.com")
users = [user1, user2]
UserSchema().dump(users, many=True)
```

### Deserializing

**Deserializing Objects: `loading`**
- create object from json/python dict

```python
user_data = {
    'created_at': '2014-08-11T05:26:03.869245',
    'email': u'ken@yahoo.com',
    'name': u'Ken'
}
schema = UserSchema()
result = schema.load(user_data)
```
