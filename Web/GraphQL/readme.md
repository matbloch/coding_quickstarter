# GraphQL




Resources:
- https://graphql.github.io/learn/schema/
- https://docs.graphene-python.org/en/latest/quickstart/
- https://github.com/Getmrahul/Flask-Graphene-SQLAlchemy/blob/master/schema.py

## Concepts



![from-db-to-client](H:\projects_dev\coding_quickstarter\Web\GraphQL\img\from-db-to-client.jpeg)



## Schemas



- 3 types



#### Object Type

- `Character` is a **GraphQL Object Type**
- `name`, `appearsIn` are **fields**
- `[]` represents an array
- `!` means non-nullable (service always gives a value when you query for this type)
- `isHigherThan:height` required parameters
- `height:unit` optional parameter, when default value is provided

```python
type Character {
  name: String!
  appearsIn: [Episode]!
  isHigherThan(height: Int): Bool
  height(unit: LengthUnit = METER): Float
}
```



#### Query Type

- same as object type
- define **entrypoint** of every GraphQL query

```python
type Query {
  hero(episode: Episode): Character
  droid(id: ID!): Droid
}
```









```python
class Query(graphene.ObjectType):
    hello = graphene.String(name=graphene.String(default_value="stranger"))

    def resolve_hello(self, info, name):
        return 'Hello ' + name
```





#### Mutation Type



## Querying



```python
result = schema.execute('{ hello }')
print(result.data['hello']) # "Hello stranger"

```







## GraphQL Language



**Arguments**



```python
{
  human(id: "1000") {
    name
    height(unit: FOOT)
  }
}
```



**Aliases**

```json
{
  empireHero: hero(episode: EMPIRE) {
    name
  }
  jediHero: hero(episode: JEDI) {
    name
  }
}
```





**Fragments**





**Operation Name**

```python
query HeroNameAndFriends {
  hero {
    name
    friends {
      name
    }
  }
}
```





**Variables**

```python
query HeroNameAndFriends($episode: Episode) {
  hero(episode: $episode) {
    name
    friends {
      name
    }
  }
}
```

pass in separate json:

```json
{
  "episode": "JEDI"
}
```











## Integration



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





#### Defining Schemas

```python

import graphene
from graphene_sqlalchemy import SQLAlchemyConnectionField, SQLAlchemyObjectType
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













