# Graphene and SQL-Alchemy



### Schemas

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





### Queries



**Standard Query Resolvers**

- `{SQL-Alchemy-ObjectType}.get_query()` get a query to fetch the models

```python
class Query(graphene.ObjectType):
    users = graphene.List(User)

    def resolve_users(self, info):
        query = User.get_query(info)  # SQLAlchemy query
        return query.all()
```

Alternative:

- Use `SQLAlchemyConnectionField` which encapsulates a `graphene.relay` connection



**Example**

```python
from graphene_sqlalchemy import SQLAlchemyObjectType
from graphene_sqlalchemy import SQLAlchemyConnectionField
import graphene

class User(SQLAlchemyObjectType, AnnotatorAttribute):
    class Meta:
        model = UserModel # the SQLAlchemy DB-Model
       
        # only return specified fields
        only_fields = ("name",)
        # exclude specified fields
        exclude_fields = ("last_name",)
        interfaces = (graphene.relay.Node,)
        

class Query(graphene.ObjectType):
    """Query objects for GraphQL API."""
    node = graphene.relay.Node.Field() # required
    # annotators
    user = graphene.relay.Node.Field(User)
    userList = SQLAlchemyConnectionField(User)

schema = graphene.Schema(query=Query)
```



**Example Query**

```json
query {
  userList {
    edges {
      node {
        id
        name
      }
    }
  }       
}
```



### Mutations







### Executing the Queries/Mutations



`schema = graphene.Schema(query=Query)`



# SQL-Alchemy & Relay

- [Example: SQLAlchemy & Grapheme & Relay](https://github.com/graphql-python/graphene-sqlalchemy/blob/master/examples/nameko_sqlalchemy/schema.py)