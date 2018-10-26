# GraphQL





## Concepts





## Integration



**Example Tech Stack**

- Webserver: Flask
- GraphQL Python Library: Graphene
- Graphene-SQLAlchemy: SQL-Alchemy Plugin for Graphene
- SQL-Alchemy: ORM DB Plugin





#### Defining Models





#### Defining Schemas

```python

from graphene import relay
from graphene_sqlalchemy import SQLAlchemyObjectType, SQLAlchemyConnectionField
from models import db_session, DepartmentModel, EmplyeeModel

class Department(SQLAlchemyObjectType):
    class Meta:
        model = DepartmentModel
        interfaces = (relay.Node, )


```





#### Endpoint Definition





#### Alterations





**Validation**





#### Authentication













