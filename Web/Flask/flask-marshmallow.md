# Slick APIs: SQL-Alchemy & Marshmallow





**Integration**

- Flask-Alchemy must be initialized before Flask-Marshmallow



```python
from flask_marshmallow import Marshmallow
app = Flask(__name__)
ma = Marshmallow(app)
```



### Output Format/Schema Definition

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





**Output Schema**

```python
class AuthorSchema(ma.ModelSchema):
    class Meta:
        model = Author

class BookSchema(ma.ModelSchema):
    class Meta:
        model = Book
    
```



