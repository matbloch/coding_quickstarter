# Graphene and SQL-Alchemy





## Queries



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





## Mutations







