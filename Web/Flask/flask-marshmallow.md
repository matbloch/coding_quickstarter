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




# Schemas

## Defining the Schemas

#### 1. Model Definition

```python
import datetime as dt

class User(object):
    def __init__(self, name, email):
        self.name = name
        self.email = email
        self.created_at = dt.datetime.now()
```

#### 2. Output Schema

```python
from marshmallow import Schema, fields
class UserSchema(Schema):
    name = fields.Str()
    email = fields.Email()
    created_at = fields.DateTime()
```

**Field Options**

- `required`
- `allow_none`
- `load_only`
- `dump_only` "read-only" skip field during

#### 3. Runtime Options

```python
my_schema = MySchema({options})
```
- `only` (tuple) whitelist fields
- `exclude` (tuple) blacklist fields
- `many` (bool) `True` if schema is used to dump list of objects
- `context` (dict) pass additional data
- `load_only` (tuple) skip fields during serialization (json dump)
- `dump_only` (tuple) skip fields during de-serialization (object loading)
- `partial` (bool|tuple) ignore missing (required) fields
- `unknown` (`EXCLUDE`, `INCLUDE`, `RAISE`) 





-----

### A. Required Fields

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

### B. Unknown Fields

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


### C. Read-only/Write-only

```python
class UserSchema(Schema):
    name = fields.Str()
    # password is "write-only"
    password = fields.Str(load_only=True)
    # created_at is "read-only"
    created_at = fields.DateTime(dump_only=True)
```


### D. Nested Schemas
```python
class BlogSchema(Schema):
    title = fields.String()
    author = fields.Nested(UserSchema)
```

**Multiple objects**

```python
collaborators = fields.Nested(UserSchema, many=True)
```
`{collaborators: [{...}, {...}]}`

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

### E. Custom Fields


- hyperlinks





### F. Functions



#### Serialization

**Function**

```python
class UserSchema(Schema):
    name = fields.String()
    uppername = fields.Function(lambda obj: obj.name.upper())
```

**Method**

```python
class UserSchema(Schema):
    created_at = fields.DateTime()
    since_created = fields.Method("get_days_since_created")

    def get_days_since_created(self, obj):
        return dt.datetime.now().day - obj.created_at.day
```



#### Deserialization

```python
class UserSchema(Schema):
    # `Method` takes a method name (str), Function takes a callable
    balance = fields.Method('get_balance', deserialize='load_balance')
    def get_balance(self, obj):
        return obj.income - obj.debt
    def load_balance(self, value):
        return float(value)
```



### G. Context

- forward additional data to schema

```python
class UserSchema(Schema):
    name = fields.String()
    # Function fields optionally receive context argument
    is_author = fields.Function(lambda user, context: user == context['blog'].author)
    likes_bikes = fields.Method('writes_about_bikes')

    def writes_about_bikes(self, user):
        return 'bicycle' in self.context['blog'].title.lower()

schema = UserSchema()

user = User('Freddie Mercury', 'fred@queen.com')
blog = Blog('Bicycle Blog', author=user)

schema.context = {'blog': blog}
```



### H. Relationships

Two options to provide relationship resource:

- As reference (e.g. link or id)
- As embedding (full nested representation)

**Two-way Nesting**

- Use class name string in first reference
- use **exclude** to avoid recursion

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

#### References

**Limiting Fields at Runtime**

```python
class SiteSchema(Schema):
    blog = fields.Nested(BlogSchema2)

schema = SiteSchema(only=['blog.author.email'])
result, errors = schema.dump(site)
```

```json
{
    'blog': {
        'author': {'email': u'monty@python.org'}
    }
}
```

**Pluck**

```python
class UserSchema(Schema):
    name = fields.String()
    email = fields.Email()
    friends = fields.Pluck('self', 'name', many=True)
# ... create ``user`` ...
serialized_data = UserSchema().dump(user)
pprint(serialized_data)
# {
#     "name": "Steve",
#     "email": "steve@example.com",
#     "friends": ["Mike", "Joe"]
# }
```

------

#### Embeddings

```python

```





### I. Custom Field Validation



**Lamda Validation**

```python
latitude = fields.Float(validate=lambda n: -180 <= n <=180)
```





**Using `validate`**

```python
    password = fields.Str(validate=[validate.Length(min=6, max=36)])
```



### J. Post dump/load operations



```python
class TodoSchema(Schema):
    id = fields.Int(dump_only=True)
    done = fields.Boolean(attribute='is_done', missing=False)
    user = fields.Nested(UserSchema, exclude=('joined_on', 'password'), dump_only=True)
    content = fields.Str(required=True)
    posted_on = fields.DateTime(dump_only=True)

    # Again, add an envelope to responses
    @post_dump(pass_many=True)
    def wrap(self, data, many):
        key = 'todos' if many else 'todo'
        return {
            key: data,
        }

    # We use make_object to create a new Todo from validated data
    @post_load
    def make_object(self, data):
        if not data:
            return None
        return Todo(
            content=data['content'],
            is_done=data['is_done'],
            posted_on=dt.datetime.utcnow(),
        )
```





## Meta

- Options object for schema





## Extending Schemas

- Example: envelope



## Examples and Tricks





**Different Marshmallow.field and Object attribute names**

- `attribute="{internal_name}"` - name of the key to get value from when **se**

```python
class UserSchema(Schema):
    name = fields.String()
    email_addr = fields.String(attribute="email")
```

```python
user = User('Keith', email_addr='dummy@python.com')
result = UserSchema.dump(user)
# {'name': 'Keith', 'email': 'dummy@python.com'}
```







**Additional Fields at Runtime**

```python
from marshmallow import Schema, fields
class MySchema(Schema):
    def __init__(self, additional_fields=None, **kwargs):
        super().__init__(**kwargs)
        self.declared_fields.update(additional_fields)

additional_fields = {
    'foo': fields.Int()
}
sch = MySchema(additional_fields=additional_fields)
```



## Using the Schemas


### Deserializing

**Deserializing to Dict**
- create create a dictionary of field names/values from json/python dict

```python
user_data = {
    'created_at': '2014-08-11T05:26:03.869245',
    'email': u'ken@yahoo.com',
    'name': u'Ken'
}
schema = UserSchema()
result = schema.load(user_data)
# {'name': 'Ken',
#  'email': 'ken@yahoo.com',
#  'created_at': datetime.datetime(2014, 8, 11, 5, 26, 3, 869245)},
```

**Deserializing to Object**
- using `@post_load` decorator
- registers a method that is invoked after deserialization

```python
from marshmallow import Schema, fields, post_load

class UserSchema(Schema):
    name = fields.Str()
    email = fields.Email()
    created_at = fields.DateTime()

    @post_load
    def make_user(self, data):
        return User(**data)
```

```python
user_data = {
    'name': 'Ronnie',
    'email': 'ronnie@stones.com'
}
schema = UserSchema()
result = schema.load(user_data)
result # => <User(name='Ronnie')>
```

#### Validation

**Deserialization from JSON**

```python
from flask import request
from marshmallow import ValidationError

@app.route('/items/', methods=['GET'])
def process_request():
    json_data = request.get_json(force=True)
    if not json_data:
        404
    # Validate and deserialize input
    try:
    	result = ItemSchema().load(json_data)
    except ValidationError as err:
        err.messages  # => {'email': ['"foo" is not a valid email address.']}
        valid_data = err.valid_data  # => {'name': 'John'}
```

**Validation for `PUT` and `POST`**

- change fields to accept `None`


```python
class UserSchema(ModelSchema):
    class Meta:
        model = User
        ...
    name = fields.Str(missing=None, required=True)
    email = fields.Email(missing=None, required=True)
```

**Ignoring Missing Fields**

```python
// all fields optional
result = UserSchema().load({'age': 42}, partial=True)
// some fields optional
result = UserSchema().load({'age': 42}, partial=('name',))
```

**Custom Lambda Validation**

```python
age = fields.Number(validate=lambda n: 18 <= n <= 40)
```

**Using Schema for Validation only**

```python
LenientSchema().validate({'name': None})  # No errors
```





### Serializing

**Serializing Objects**

- `dump` serializes object to python dict
- creates json/python dict from object

```python
user = User(name="Monty", email="monty@python.org")
schema = UserSchema()
result = schema.dump(user)
```

**Filtering Outputs**
- `only`
- `exclude`
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



##  Integration with SQL-Alchemy

- use `additional` to add besides the defined fields



```python
class UserSchema(Schema):
    uppername = fields.Function(lambda obj: obj.name.upper())
    class Meta:
        # No need to include 'uppername'
        additional = ("name", "email", "created_at")
```





```python

class UserSchema(Schema):
    class Meta:
        fields = ("id", "email", "date_created")
        exclude = ("password", "secret_attribute")

```

