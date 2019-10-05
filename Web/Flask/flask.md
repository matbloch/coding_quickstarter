# Flask









## Best Practices



### 1. Use Application Factories

- Testing: Allows to create different `app` instances
- Prevent circular imports: `from app import app`



**Use an application factory**

```python
from flask import Flask

def factory():
    app = Flask(__name__)
    return app
```

**Use `current_app` to access the app**

```python
from flask import current_app
current_app.config['RELEVANT_CONFIG_VARIABLE']
```



### 2. Modular configurations

**Configure the application**

```python
def create_app(config=None, environment=None):
    app = Flask(__name__)
    app.config['ENVIRONMENT'] = environment
    app.config.update(config or {})
    return app
```







## Configuration Handling

-  see [Documentation](https://flask.palletsprojects.com/en/1.1.x/config/)

- https://pythonise.com/feed/flask/flask-configuration-files



#### Best Practices

config.py

```python
class Config(object):
    DEBUG = False
    TESTING = False

class ProductionConfig(Config):
    pass

class DevelopmentConfig(Config):
    DEBUG = True

class TestingConfig(Config):
    TESTING = True
```

```python¨

```





#### Built-In Configuration Variables

- `ENV` (default `'production'`) flask extension may enable behaviour based on the environment
- `DEBUG` (default `false`) exceptions are thrown and printed to console, hot reloading etc.
- `TESTING` (default `false`)exceptions are propagated instead of handled by app
- `SECRET_KEY` String to encrypt sensitive information

#### Configuration Sources

- `app.config.from_object('config.Config')` from object

- `app.config.from_envvar('APP_CONFIG')` from filepath in env

- `app.config.from_pyfile('application.cfg', silent=True)` from .cfg file







## Routing
- `<converter:variable_name>`
	- `string`
	- `int`
	- `float`
	- `path`
	- `uuid`


```python
@app.route('/user/<username>')
def show_user_profile(username):
    # show the user profile for that user
    return 'User %s' % username

@app.route('/post/<int:post_id>')
def show_post(post_id):
    # show the post with the given id, the id is an integer
    return 'Post %d' % post_id
```

**URL building**
`print(url_for('show_user_profile', username='John Doe'))`


### Blueprints

**Blueprint definition `admin.py`**
```python
from flask import Blueprint
admin_blueprint = Blueprint('admin', __name__)

@admin.route('/items/', methods=['GET'])
def get_items():
	pass
```

**Blueprint registration**
```python
from .admin import admin_blueprint
app.register_blueprint(admin_blueprint, url_prefix="/admin")

```

#### HTTP Methods
```python
from flask import request

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
    	pass
```


#### The Request Object

**JSON**
```python
@app.route('/login', methods=['POST'])
def login():
    json_data = request.get_json(force=True)
	if not json_data:
    	return 400
```

**Forms**

```python
@app.route('/login', methods=['POST', 'GET'])
def login():
    error = None
    if request.method == 'POST':
        if valid_login(request.form['username'],
                       request.form['password']):
            return log_the_user_in(request.form['username'])
        else:
            error = 'Invalid username/password'
    # the code below is executed if the request method
    # was GET or the credentials were invalid
    return render_template('login.html', error=error)
```


**Files**
```python
from flask import request

@app.route('/upload', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        f = request.files['the_file']
        f.save('/var/www/uploads/uploaded_file.txt')
```

**URL parameters**
- `?key=value`
- `searchword = request.args.get('key', '')` get specific key

