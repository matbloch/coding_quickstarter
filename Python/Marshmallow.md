# Marshmallow: Simplified object serialization

https://marshmallow.readthedocs.io/en/stable/





### Defining Schemas



**Creating a Schema**

```python
from marshmallow import Schema, fields

class ArtistSchema(Schema):
    name = fields.Str()
```

**Nested Fields**

```python
class AlbumSchema(Schema):
    artist = fields.Nested(ArtistSchema())
```

**From Dictionairy**

```python
UserSchema = Schema.from_dict(
    {"name": fields.Str(), "email": fields.Email(), "created_at": fields.DateTime()}
)
```



### Serializing Objects - "Dumping"



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





### Deserializing Objects - "Loading"



###  