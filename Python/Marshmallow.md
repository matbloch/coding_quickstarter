# Marshmallow: Simplified object serialization

https://marshmallow.readthedocs.io/en/stable/





## General Concepts



- Model <load> Schema <dump> Serialization
- dump: 
  - Don't validate, assume correctness upon construction
  - Basically a mask
- load:
  - mark required fields with `required=True`
  - **unknown** – Whether to exclude, include, or raise an error for unknown fields in the data. Use [`EXCLUDE`](https://marshmallow.readthedocs.io/en/stable/api_reference.html#marshmallow.EXCLUDE), [`INCLUDE`](https://marshmallow.readthedocs.io/en/stable/api_reference.html#marshmallow.INCLUDE) or [`RAISE`](https://marshmallow.readthedocs.io/en/stable/api_reference.html#marshmallow.RAISE).













## Defining Schemas

**Creating a Schema**

```python
from marshmallow import Schema, fields

class ArtistSchema(Schema):
    name = fields.Str()
```

**From Dictionary**

```python
UserSchema = Schema.from_dict(
    {"name": fields.Str(), "email": fields.Email(), "created_at": fields.DateTime()}
)
```



### Special Field Types

**Nested Fields**

```python
class AlbumSchema(Schema):
    artist = fields.Nested(ArtistSchema())
```

**Handling Unknowns**

```python
from marshmallow import Schema, INCLUDE
class UserSchema(Schema):
    class Meta:
        unknown = INCLUDE
```

**Default Values**

```python
class UserSchema(Schema):
    id = fields.UUID(missing=uuid.uuid1)
    birthdate = fields.DateTime(default=dt.datetime(2017, 9, 29))
```

**Read- and Write-only Fields**

```python
class UserSchema(Schema):
    name = fields.Str()
    # password is "write-only"
    password = fields.Str(load_only=True)
    # created_at is "read-only"
    created_at = fields.DateTime(dump_only=True)
```





## Serializing Objects - "Dumping"

```python
user = User(name="Monty", email="monty@python.org")
schema = UserSchema()
result = schema.dump(user)
pprint(result)
```

Encoded string:
```python
json_result = schema.dumps(user)
```


Formated:
```python
result = schema.dump(user)
```





## Validation

- Primarily for performance reasons, validation only  happens on deserialization (`load` and `validate`). The data passed to  `dump` is assumed to be valid.
- can be performed without deserialization

```python
errors = UserSchema().validate({"name": "Ronnie", "email": "invalid-email"})
print(errors)  # {'email': ['Not a valid email address.']}
```



**Required fields**

- error on `load`

```python
fields.String(required=True)
```

**Selection of Values**

```python
fields.Str(validate=validate.OneOf(["read", "write", "admin"]))
```

**Ranges**

```python
fields.Int(validate=validate.Range(min=18, max=40))
```



#### Functional Validation

**Free Function**

```python
def validate_quantity(n):
    if n < 0:
        raise ValidationError("Quantity must be greater than 0.")
class ItemSchema(Schema):
    quantity = fields.Integer(validate=validate_quantity)
```

**Validation Decorators**

```python
class ItemSchema(Schema):
    quantity = fields.Integer()

    @validates("quantity")
    def validate_quantity(self, value):
        if value < 0:
            raise ValidationError("Quantity must be greater than 0.")
```





## Deserializing Objects - "Loading"

- validation is performed automatically

###  

**Filtering**

```python
summary_schema = UserSchema(only=("name", "email"))
summary_schema.dump(user)
```



**Deserialization to Object**

- `<schema>.load()` will return object instance

```python
from marshmallow import Schema, fields, post_load

class UserSchema(Schema):
    name = fields.Str()
    email = fields.Email()
    created_at = fields.DateTime()

    @post_load
    def make_user(self, data, **kwargs):
        return User(**data)
```

```python
user_data = {"name": "Ronnie", "email": "ronnie@stones.com"}
schema = UserSchema()
result = schema.load(user_data)
print(result)  # => <User(name='Ronnie')>
```

