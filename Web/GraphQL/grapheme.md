# Grapheme

Python and JavaScript library for a GraphQL server.

**Reads**

- [Grapheme example on Medium](https://medium.com/@fasterpancakes/graphql-server-up-and-running-with-50-lines-of-python-85e8ada9f637)

**Overview**

- **Schema**: Contract UI and backend agree on. Defines the possible Queries and Mutations
  - **Queries**: For data fetching
  - **Mutations**: For data alteration

- **ObjectTypes**: define relationship between schema fields and how data is retreived
  - **Fields**: The attributes of a datatype
  - Can e.g. automatically be inferred from a database model using SQLAlchemy



## Schema Definition

- describes data model: Methods to **resolve **or **mutate** data

**Definition**

```python
schema = graphene.Schema(
    query=Query, 	# query resolvers
    mutation=MyMutations, # mutation resolvers
    types=[SomeExtraObjectType, ]  # return types
)
```



- combines query and mutation definitions

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
  
# 3. Query
class MyQuery(graphene.ObjectType):
    person = graphene.Field(Person)
    
# 4. Mutations
class MyMutations(graphene.ObjectType):
    create_person = CreatePerson.Field()

# 5. The Schema
schema = graphene.Schema(query=MyQuery, mutation=MyMutations)
```



**Custom Return Types Types**

- add additional `types`, if field returns e.g. an `Implementation`

```python
my_schema = Schema(
    query=MyRootQuery,
    types=[SomeExtraObjectType, ]
)
```



## Executing GraphQL Queries

- use: `schema.execute(query_str)`

```python
schema = Schema(query=Query)
query_string = '''
    query getUser {
        user {
            id
            firstName
            lastName
        }
    }
    '''
result = schema.execute(query_string)
```

Example query string:

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



## Basic Field Types

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


    - with self reference: `graphene.List(lambda: Character)`

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

- Defines relationship between **fields in the GraphQL schema** and how data is retrieved
- Each attribute represents a `Field`
- Each `Field` has a resolve method

**Basic Example**

```python
class Person(graphene.ObjectType):
    name = graphene.String()
# Is equivalent to:
class Person(graphene.ObjectType):
    name = graphene.Field(graphene.String)
```

> **NOTE:** All Scalars mounted in a `ObjectType`, `Interface` or `Mutation` act as `graphene.Field` and act as **arguments**



**graphene.Field**

```python
class Person(ObjectType):
    first_name = graphene.String(required=True)                # implicitly mounted as Field
    last_name = graphene.Field(String, description='Surname')  # explicitly mounted as Field
```

**graphene.InputField**

- can't have arguments `args` on their input fields, unlike regular `graphene.Field`
- nested input fields: use subfields

**graphene.InputObjectType**

- collection of fields which may be supplied to a field argument
- use `graphene.NonNull` or `required` to make fields required
- all attributes of `InputObjectType` are mounted as `InputField`

```python
class Person(InputObjectType):
    # implicitly mounted as Input Field
    first_name = String(required=True)
    # explicitly mounted as Input Field
    last_name = InputField(String, description="Surname")
```



### Resolvers

- Methods to fetch data for a schema field

- default name: `resolve_{field_name}`
  - does not need to be `static`, Graphene calls it implicitly
- arguments: Any argument that a field defines gets passed to resolver
- predefined arguments: 
  - `info` Query execution info
  - `parent` Parent value object

```python
class Query(ObjectType):
    # defines required field "name"
    human_by_name = Field(Human, name=String(required=True))
	# "name" gets passed as argument to resolver
    def resolve_human_by_name(parent, info, name):
        return get_human(name=name)
```

**Parent Value Object**

```python
class Query(ObjectType):
    human_by_name = Field(Human, name=String(required=True))

    def resolve_human_by_name(parent, info):
        return get_human(name=name)
```

**GraphQL Execution Info**

- `info` argument of resolver
  - contains query execution metadata
- `info.context` can be used to store user authentication or anything else

```python
class Query(ObjectType):
    human_by_name = Field(Human, name=String(required=True))

    def resolve_human_by_name(parent, info):
        return get_human(name=name)
```













## Interfaces

- Base class that define certain set of fields
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



## Queries

1. define object scheme (fields you can query)
2. define `resolve_{field-name}`

```python
class Patron(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String(description="The persons name")

class Query(graphene.ObjectType):
    patron = graphene.Field(Patron, description="Query a user.")
    def resolve_patron(self, info):
        # fetch the object. Here: just return it.
		return Patron(id=1, name="Syrus")
    
schema = graphene.Schema(query=Query)
```

### Auto-generated Schemes

#### SQLAlchemy Auto-Generated

**Benefits**

- no input definition required

**Integration**

- inherit from `SQLAlchemyObjectType`
- documentation extracted from SQLAlchemy db model (from `doc` attribute)
- SQLAlchemy query automatically generated from query arguments

```python
class UserModel(Base):
    id = Column('id', Integer, primary_key=True, doc="Id of the person.")
    name = Column('name', String, doc="Name of the person.")
    name = Column('last_name', String, doc="The last name of the person.")
```

```python
from graphene_sqlalchemy import SQLAlchemyObjectType

class User(SQLAlchemyObjectType):
    class Meta:
        model = UserModel
        # only return specified fields
        only_fields = ("name",)
        # exclude specified fields
        exclude_fields = ("last_name",)

class Query(graphene.ObjectType):
    users = graphene.List(User)

    def resolve_users(self, info):
        query = User.get_query(info)  # SQLAlchemy query
        return query.all()
```

#### SQLAlchemy Auto-Generated & Relay

**Benefits**

- no input definition required
- no `resolve_{field-name}` method required

**Integration**

- define query object type with SQLAlchemy model and attribute `interfaces = (graphene.relay.Node,)`
- add `node = graphene.relay.Node.Field()` to `Query`
- use `graphene.relay.Node.Field` as type for single object query
- use `SQLAlchemyConnectionField` as type for multi object query

```python
class User(SQLAlchemyObjectType):
    class Meta:
        model = UserModel
        interfaces = (graphene.relay.Node,)  # required
        # additional restrictions
        only_fields = ("name",)
        exclude_fields = ("last_name",)
        
class Query(graphene.ObjectType):
    """Query objects for GraphQL API."""
    node = graphene.relay.Node.Field()  # required
    user = graphene.relay.Node.Field(User)
    users = SQLAlchemyConnectionField(User)
```

**Example Query**

```json
query {
  users {
    edges {
      node {
        id
        name
      }
    }
  }       
}
```



### Custom Queries

**Queries with additional arguments**

- additional argument not directly related to object attribute
- add to `graphene.Field` as additional argument
- write custom resolver with additional argument

```python
class Character(graphene.Interface):
    id = graphene.ID(required=True)
    name = graphene.String(required=True)
    friends = graphene.List(lambda: Character)
    
class Query(graphene.ObjectType):
    hero = graphene.Field(
        Character,
        required=True,
        episode=graphene.Int(required=True)
    )

    # custom resolver with additional attribute
    def resolve_hero(_, info, episode):
        if episode == 5:
            return get_human(name='Luke Skywalker')
        return get_droid(name='R2-D2')

schema = graphene.Schema(query=Query, types=[Human, Droid])
```

**Search Query**

- search across different models

```python
class Book(SQLAlchemyObjectType):
    class Meta:
        model = BookModel
        interfaces = (relay.Node,)
class BookConnection(relay.Connection):
    class Meta:
        node = Book
class Author(SQLAlchemyObjectType):
    class Meta:
        model = AuthorModel
        interfaces = (relay.Node,)
class AuthorConnection(relay.Connection):
    class Meta:
        node = Author
class SearchResult(graphene.Union):
    class Meta:
        types = (Book, Author)
class Query(graphene.ObjectType):
    node = relay.Node.Field()
    search = graphene.List(SearchResult, q=graphene.String())  # List field for search results
    # Normal Fields
    all_books = SQLAlchemyConnectionField(BookConnection)
    all_authors = SQLAlchemyConnectionField(AuthorConnection)

    def resolve_search(self, info, **args):
        q = args.get("q")  # Search query
        # Get queries
        bookdata_query = BookData.get_query(info)
        author_query = Author.get_query(info)
        # Query Books
        books = bookdata_query.filter((BookModel.title.contains(q)) |
                                      (BookModel.isbn.contains(q)) |
                                      (BookModel.authors.any(AuthorModel.name.contains(q)))).all()

        # Query Authors
        authors = author_query.filter(AuthorModel.name.contains(q)).all()
        return authors + books  # Combine lists
schema = graphene.Schema(query=Query, types=[Book, Author, SearchResult])
```



## Mutations

- outputs: `person`, `ok` (optional, status of mutation)
- arguments: `name` (defined by `Arguments` class)
- `mutate()` method has to be implemented
- `Arguments` class implements the input parameters

```python
class Person(graphene.ObjectType):
    name = graphene.String()
    age = graphene.Int()

class CreatePerson(graphene.Mutation):
    class Arguments:
        name = graphene.String(required=True)

    ok = graphene.Boolean()
    person = graphene.Field(lambda: Person)

    def mutate(self, info, name):
        person = Person(name=name)
        ok = True
        return CreatePerson(person=person, ok=ok)
```

```python
class MyMutations(graphene.ObjectType):
    create_person = CreatePerson.Field()

# We must define a query for our schema
class Query(graphene.ObjectType):
    person = graphene.Field(Person)

schema = graphene.Schema(query=Query, mutation=MyMutations)
```

query:

```json
mutation myFirstMutation {
    createPerson(name:"Peter") {
        person {
            name
        }
        ok
    }
}
```

**Nested inputs**

- allows to pass a dictionary as argument for the mutation
- use `graphene.InputField` for nested input arguments

```python
class AddressInput(graphene.InputObjectType):
    street = graphene.String(required=True)
    city = graphene.String()

class PersonInput(graphene.InputObjectType):
    name = graphene.String(required=True)
    age = graphene.Int(required=True)
    # nested input type
    address = graphene.InputField(AddressInput)

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

query:

```json
mutation myFirstMutation {
    createPerson(personData: {name:"Peter", age: 24}) {
        person {
            name,
            age
        }
    }
}
```

**Specifying the output type**

- assign model class to `Output`
- allows to specify explicit instead of mutation-specific object type as output 

```python
class CreatePerson(graphene.Mutation):
    class Arguments:
        name = graphene.String()
    Output = Person
    def mutate(self, info, name):
        return Person(name=name)
```



### Auto-generated Schemes

#### SQLAlchemy Mutations

```python
class Planet(SQLAlchemyObjectType):
    class Meta:
        model = ModelPlanet
        interfaces = (graphene.relay.Node,)
```

**Insert**


```python
class CreatePlanetInput(graphene.InputObjectType):
    name = graphene.String(description="Name of the planet.")
    
class CreatePlanet(graphene.Mutation):
    planet = graphene.Field(lambda: Planet, description="created planet.")

    class Arguments:
        input = CreatePlanetInput(required=True)

    def mutate(self, info, input):
        data = utils.input_to_dictionary(input)
        data['created'] = datetime.utcnow()
        data['edited'] = datetime.utcnow()
        planet = ModelPlanet(**data)
        db_session.add(planet)
        db_session.commit()
        return CreatePlanet(planet=planet)
```

**Update**

```python
class UpdatePlanetInput(graphene.InputObjectType, PlanetAttribute):
    """Arguments to update a planet."""
    id = graphene.ID(required=True, description="Global Id of the planet.")
    name = graphene.String(required=True, description="Name of the planet.")

class UpdatePlanet(graphene.Mutation):
    planet = graphene.Field(lambda: Planet, description="Updated planet.")

    class Arguments:
        input = UpdatePlanetInput(required=True)

    def mutate(self, info, input):
        data = utils.input_to_dictionary(input)
        data['edited'] = datetime.utcnow()

        planet = db_session.query(ModelPlanet).filter_by(id=data['id'])
        planet.update(data)
        db_session.commit()
        planet = db_session.query(ModelPlanet).filter_by(id=data['id']).first()

        return UpdatePlanet(planet=planet)
```

Query:

```json
mutation {
  updatePlanet (input:{
    id: "UGxhbmV0Ojk"
    name: "The new planet name"
  }) {
    planet {
      id
      name
	}
}
```



## Custom Feedback Messages



## Error Handling

https://www.howtographql.com/graphql-python/6-error-handling/



## Server-Side Input Validation

- [Authorization Middleware](https://docs.graphene-python.org/en/latest/execution/middleware/)





## Mutations

**Example**

- outputs: `ok`, `person`
- arguments: `name` (defined by `Arguments` class)
- mutation function: `mutate` (will be called uppon mutation)

````python
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







**Separate inputs into class**

```python
class People(SQLAlchemyObjectType):
    """People node."""

    class Meta:
        model = ModelPeople
        interfaces = (graphene.relay.Node,)
        
class CreatePersonInput(graphene.InputObjectType):
    """Arguments to create a person."""
    name = graphene.String(required=True, description="Name of the person.")
    height = graphene.String(description="Height of the person.")

class CreatePerson(graphene.Mutation):
    # output of the mutation
    person = graphene.Field(lambda: People, description="Person created by this mutation.")
    class Arguments:
        input = CreatePersonInput()

```

The query: Create the person and fetch it's name

```json
mutation {
  createPerson (input: {
    name: "Alexis ROLLAND"
    height: "189"
    }) {
    person {
      name
	}
}
```









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







# Relay Integration

- Graphene has built-in support for *Relay*
- **Benefits**: Auto-creation of search queries



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





# SQL-Alchemy & Relay

- [Example: SQLAlchemy & Grapheme & Relay](https://github.com/graphql-python/graphene-sqlalchemy/blob/master/examples/nameko_sqlalchemy/schema.py)







# Frontend Integration

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







