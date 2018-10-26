# Restful APIs with FLASK


## Design

### REST Resources

- document (single item): /api/v1/cars/123
- collection: /api/v1/cars




- Although the internal models of your application may map neatly to resources, it isn't necessarily a one-to-one mapping. Avoid leaking implementation details out to your API.

**Many-to-Many Relationships**

- hypermedia as the engine of application state (HATEOAS)
	- resource representations come along with hyperlinks making it easier for clients to identify possible actions

**Creating/Updating Relationships**




## Implementation

```python
from flask import Flask, request
from flask_restful import Resource, Api

app = Flask(__name__)
api = Api(app)

todos = {}

class TodoSimple(Resource):
    def get(self, todo_id):
        return {todo_id: todos[todo_id]}

    def put(self, todo_id):
        todos[todo_id] = request.form['data']
        return {todo_id: todos[todo_id]}

api.add_resource(TodoSimple, '/<string:todo_id>')

if __name__ == '__main__':
    app.run(debug=True)
```


**Return Format**

- `return` `content` `status-code`, `headers`

`return {'task': 'Hello world'}, 201, {'Etag': 'some-opaque-string'}`



# Flask RESTFul

#### Passing Parameters to Resource

```python
from flask.ext.restful import Resource

class ApiPage(Resource):
    def __init__(self, bar):
        self.bar = bar

    def get(self):
        serialized = str(my_bar)
        return serialized
```

```python
# ...
my_bar = Bar()
api.add_resource(views.ApiPage, '/api/my/end/point/',
                 resource_class_kwargs={'bar': my_bar})
```


#### Decorators for Routing

```python
from flask import Flask
from flask.ext import restful
import types

app = Flask(__name__) 
api = restful.Api(app)


def api_route(self, *args, **kwargs):
    def wrapper(cls):
        self.add_resource(cls, *args, **kwargs)
        return cls
    return wrapper

api.route = types.MethodType(api_route, api)
```

```python
from flask.ext import restful
from yourapplication import api

@api.route('/users/{username}')
class User(restful.Resource):
   
    def get(self, username):
        return {'username': username}
```


## RESTful Design

Example Model:

```python
class MyModel:
    
```



**Modelling Considerations**

- 





GET:



POST:



PUT:

```json
{
    children: [2, 4, 5]
}
```



- field_data = theSchema(partial=True, exclude='children').load(request.json)
- child_ids = 



DELETE:





**Different Load/Dump Contents**



```python
class ParentSchema(Schema):
    id = fields.Int(dump_only=True)
    children = fields.Nested(ChildSchema, dump_only=True, many=True)
    children_ids = fields.List(fields.Int, load_only=True, attribute='children')
```

Dumping nested, embedded objects

```python
ParentSchema().dump(parent)
# {id=123, children=[{...}, {...}]}
```

Loading/Validating just the ids

```python
parent_json = "{'id': 123, 'children': [3, 5, 9]}"
parent = ParentSchema().load(parent_json)
# parent.children_ids
# [3, 5, 9]
```











**Make all fields optional**



```python
class UserSchema(ModelSchema):
    class Meta:
        model = User
        ...
    name = fields.Str(missing=None, required=True)
    email = fields.Email(missing=None, required=True)
```

```python
class UserSchema(Schema):
    name = fields.Str(required=True)
```

```python
s.validate({})  # {'name': ['Missing data for required field.']}
s.validate({'name': None})  #  No errors
s.validate({'name': ''})  # No errors
```

```python
if kwargs[d] is not missing and kwargs[d] is not None:
```

