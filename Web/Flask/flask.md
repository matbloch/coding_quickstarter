# Flask



## Best Practices

- See also: https://hackersandslackers.com/demystifying-flask-application-factory/

- example app: https://github.com/JackStouffer/Flask-Foundation/blob/master/manage.py





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

**Defining Configurations**

- Don't set `ENV` , use the environment variable `FLASK_ENV`







### Extensions

- instantiate globally in `__init__.py`
- setup in application factory using `init_app()`

Default structure of a Flask extension:

```python
class FlaskExtension(object):
    def __init__(self, app=None):
        if app:
            self.init_app(app)

    def init_app(self, app):
        if not hasattr(app, 'extensions'):
            app.extensions = {}
        app.extensions['EXTENSION'] = self
```









## Configuration Handling

-  see [Documentation](https://flask.palletsprojects.com/en/1.1.x/config/)
- https://hackersandslackers.com/configuring-your-flask-application/



#### Basics

- Configuration (including extensions) is stored in`config` attribute of `Flask` object

- Access through `from flask import current_app`, see best practices section

**Environment Variables**

- `FLASK_ENV`  (default: `production`)
  - Used by extensions. Available already before Flask setup, as compared to `DEBUG` and `ENV` in config
  - **should always be set**
  - options: 'development', 'testing', 'production'

**Built-In Configuration Variables**

- `ENV` (default `'production'`) flask extension may enable behaviour based on the environment
  - **NOTE:** Don't set `ENV` in your config, instead set the environment variable `FLASK_ENV`
- `DEBUG` (default `false`) exceptions are thrown and printed to console, hot reloading etc.
- `TESTING` (default `false`) exceptions are propagated instead of handled by app
- `SECRET_KEY` String to encrypt sensitive information

**Configuration Sources**

- `app.config.from_object('config.Config')` from object
- `app.config.from_envvar('APP_CONFIG')` from filepath in env
- `app.config.from_pyfile('application.cfg', silent=True)` from .cfg file



#### Examples

**Config Properties**

```python
class Config:
    DB_SERVER = '192.168.1.56'
    @property
    def DATABASE_URI(self):         # Note: all caps
        return 'mysql://user@{}/foo'.format(self.DB_SERVER)
```

**Object Based Configuration**

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

**Configuring Paths**

```python
filename = os.path.join(app.instance_path, 'my_folder', 'my_file.txt')
```





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

@admin_blueprint.route('/items/', methods=['GET'])
def get_items():
	pass
```

**Blueprint registration**
```python
from .admin import admin_blueprint
app.register_blueprint(admin_blueprint, url_prefix="/admin")

```

**Dynamic URLs**

```python
url_for('admin.get_items')
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

