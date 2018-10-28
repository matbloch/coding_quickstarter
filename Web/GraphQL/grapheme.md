# Grapheme



**Reads**

- [Grapheme example on Medium](https://medium.com/@fasterpancakes/graphql-server-up-and-running-with-50-lines-of-python-85e8ada9f637)



## Schemas

**Definition**

`schema = graphene.Schema(query=Query, mutation=MyMutations)`

```python
# 1. Mutation
class CreatePerson(graphene.Mutation):
    class Arguments:
        name = graphene.String()

    ok = graphene.Boolean()
    person = graphene.Field(lambda: Person)

    def mutate(self, info, name):
        person = Person(name=name)
        ok = True
        return CreatePerson(person=person, ok=ok)
# 2. Object
class Person(graphene.ObjectType):
    name = graphene.String()
    age = graphene.Int()
# 3. Mutations
class MyMutations(graphene.ObjectType):
    create_person = CreatePerson.Field()
# 4. Query
class Query(graphene.ObjectType):
    person = graphene.Field(Person)
# 5. The Schema
schema = graphene.Schema(query=Query, mutation=MyMutations)
```



**Types**

- add additional `types`, if field returns e.g. an `Implementation`

```python
my_schema = Schema(
    query=MyRootQuery,
    types=[SomeExtraObjectType, ]
)
```

**Querying**

- use: `schema.execute(query_str)`

with e.g.:

```python
mutation myFirstMutation {
    createPerson(name:"Peter") {
        person {
            name
        }
        ok
    }
}
```



## Fields

- **default output names**: all fields will be renamed from `snake_case` to `camelCase` in API output

#### Scalar Types

**Types**

- `graphene.String`
- `graphene.Int`
- `graphene.Float`
- `graphene.Boolean`
- `graphene.ID`	unique identifier
- `graphene.types.datetime.Date`
- `graphene.types.datetime.DateTime`
- `graphene.types.datetime.Time`
- `graphene.types.json.JSONString`

**Arguments**
- `name` override name field
- `description`
- `required` if `True`, equals to `NonNull` field
- `deprecation_reason`
- `default_value`


#### Special Types


- List: `graphene.List(graphene.String)`
- Non-null: `graphene.NonNull(graphene.String)`

  - Equivalent to: `graphene.String(required=True)`

- Enums:

  ```
  class Episode(graphene.Enum):
      NEWHOPE = 4
      EMPIRE = 5
  ```

  or instance declaration

  ```python
  Episode = graphene.Enum('Episode', [('NEWHOPE', 4), ('EMPIRE', 5)])
  ```



## Object Types



```python
class Person(graphene.ObjectType):
    first_name = graphene.String()
    last_name = graphene.String()
    full_name = graphene.String()
```





#### Resolvers

- default name: `resolve_{field_name}`

```python
class Person(graphene.ObjectType):
    word_reverse = graphene.String()
    def resolve_word_reverse(self, info, word):
        return word[::-1]
```

#### Interfaces

- Base class that define certain set of fields that 
- Each class that implements interface **inherits** fields

```python
class XYZ(graphene.ObjectType):
    # ...
    class Meta:
        interfaces = (MyInterface, )
```

**Example**

```python
class Character(graphene.Interface):
    id = graphene.ID(required=True)
    name = graphene.String(required=True)
    friends = graphene.List(lambda: Character)
    
class Human(graphene.ObjectType):
    class Meta:
        interfaces = (Character, )

    starships = graphene.List(Starship)
```

#### Abstract Types

...



## Query Types



```python
class Query(graphene.ObjectType):
    hero = graphene.Field(
        Character,
        required=True,
        episode=graphene.Int(required=True)
    )

    def resolve_hero(_, info, episode):
        # Luke is the hero of Episode V
        if episode == 5:
            return get_human(name='Luke Skywalker')
        return get_droid(name='R2-D2')

schema = graphene.Schema(query=Query, types=[Human, Droid])
```



## Unions

- used to refer to possible objecttypes

```python
import graphene

class Human(graphene.ObjectType):
    name = graphene.String()
    born_in = graphene.String()

class Droid(graphene.ObjectType):
    name = graphene.String()
    primary_function = graphene.String()

class Starship(graphene.ObjectType):
    name = graphene.String()
    length = graphene.Int()

class SearchResult(graphene.Union):
    class Meta:
        types = (Human, Droid, Starship)
```



## Mutations

**Example**

- outputs: `ok`, `person`
- arguments: `name` (defined by `Arguments` class)
- mutation function: `mutate` (will be called uppon mutation)

````python
import graphene

class CreatePerson(graphene.Mutation):
    class Arguments:
        name = graphene.String()

    ok = graphene.Boolean()
    person = graphene.Field(lambda: Person)

    def mutate(self, info, name):
        person = Person(name=name)
        ok = True
        return CreatePerson(person=person, ok=ok)
````



#### Object as Input

- define input object structure (`PersonInput`)
- use it in mutation definition

```python
class PersonInput(graphene.InputObjectType):
    name = graphene.String(required=True)
    age = graphene.Int(required=True)

class CreatePerson(graphene.Mutation):
    class Arguments:
        person_data = PersonInput(required=True)

    person = graphene.Field(Person)

    @staticmethod
    def mutate(root, info, person_data=None):
        person = Person(
            name=person_data.name,
            age=person_data.age
        )
        return CreatePerson(person=person)
```









# Relay: Integration

- Graphene has built-in support for *Relay*





## Connections

- ++ version of list that allows slicing and pagination



**All connection classes have**

- `pageInfo`
- `edges`



### Connection Fields

```python
class Faction(graphene.ObjectType):
    name = graphene.String()
    ships = relay.ConnectionField(ShipConnection)

    def resolve_ships(self, info):
        return [] # ...
```



### Custom Connections

- `extra` an extra field of the connection
- `other_extra` an extra field in the connection edge

```python
class ShipConnection(Connection):
    extra = String()
    class Meta:
        node = Ship
    class Edge:
        other_extra = String()
```



## Nodes

- Interface provided by `graphene.relay`
  - field: `id: ID!` 
  - method: `get_node(cls, info, id)` get node by id

**Example**

```python
class Ship(graphene.ObjectType):
    '''A ship in the Star Wars saga'''
    class Meta:
        interfaces = (relay.Node, )

    name = graphene.String(description='The name of the ship.')

    @classmethod
    def get_node(cls, info, id):
        return get_ship(id)
```

**Root Node**

```python
class Query(graphene.ObjectType):
    # Should be CustomNode.Field() if we want to use our custom Node
    node = relay.Node.Field()
```





# SQLAlchemy: Integration

**Object definition from SQLAlchemy model**

- inherit from `SQLAlchemyObjectType`

- parameters:
  - `only_fields`
  - `exclude_fields`

```python
from graphene_sqlalchemy import SQLAlchemyObjectType

class User(SQLAlchemyObjectType):
    class Meta:
        model = UserModel
        # only return specified fields
        only_fields = ("name",)
        # exclude specified fields
        exclude_fields = ("last_name",)
```

**Standard Query Resolvers**

- `{SQL-Alchemy-ObjectType}.get_query` get a query to fetch the models

```python
class Query(graphene.ObjectType):
    users = graphene.List(User)

    def resolve_users(self, info):
        query = User.get_query(info)  # SQLAlchemy query
        return query.all()
```

Alternative:

- Use `SQLAlchemyConnectionField` which encapsulates a `graphene.relay` connection

Executing the Query:

`schema = graphene.Schema(query=Query)`

```
query = '''
    query {
      users {
        name,
        lastName
      }
    }
'''
```



# SQL-Alchemy & Relay

- [Example: SQLAlchemy & Grapheme & Relay](https://github.com/graphql-python/graphene-sqlalchemy/blob/master/examples/nameko_sqlalchemy/schema.py)







# Integration

### Frontend/Client



**Frameworks**

- Relay: React or React Native
- Apollo: Environment agnostic







### Backend



**Example Tech Stack**

- Webserver: Flask
- GraphQL Python Library: Graphene
- Graphene-SQLAlchemy: SQL-Alchemy Plugin for Graphene
- SQL-Alchemy: ORM DB Plugin





#### Defining Models

... See 



#### Defining Schemas

```python
import graphene
from graphene_sqlalchemy import 
, SQLAlchemyObjectType
from models import *

class Person(SQLAlchemyObjectType):
    class Meta:
        model = PersonModel
        interfaces = (graphene.relay.Node, )

class Article(SQLAlchemyObjectType):
    class Meta:
        model = ArticleModel
        interfaces = (graphene.relay.Node, )
        
class Query(graphene.ObjectType):
    node = graphene.relay.Node.Field()
    person = graphene.Field(Person, uuid = graphene.Int())
    
    def resolve_person(self, args, context, info):
        query = Person.get_query(context)
        uuid = args.get('uuid')
        return query.get(uuid)

schema = graphene.Schema(query=Query, types=[Person])
```



#### Endpoint Definition

- single route that is handled by a graph ql view function

```python
from flask import Flask

from database import db_session
from flask_graphql import GraphQLView
from schema import schema

app = Flask(__name__)
app.debug = True

app.add_url_rule('/graphql', view_func=GraphQLView.as_view('graphql', schema=schema, graphiql=True, context={'session': db_session}))

@app.teardown_appcontext
def shutdown_session(exception=None):
    db_session.remove()

if __name__ == '__main__':
	app.run()
```



#### Alterations





**Validation**





#### Authentication







