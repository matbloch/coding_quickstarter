# Flask



## Best Practices

- See also: https://hackersandslackers.com/demystifying-flask-application-factory/

- example app: https://github.com/JackStouffer/Flask-Foundation/blob/master/manage.py





### 0. Project Structure

```bash
README
└── app/
     ├── Dockerfile
     ├── .dockerignore
     ├── requirements.txt    # the requirements
     ├── config.py           # contains the app configuration
     ├── wsgi.py			 # WSGI entrypoint
     ├── run_debug.py		 # debug entrypoint
     └── app/
          ├── __init__.py		# contains the app factory
          ├── routing.py		# contains routing definitions
          ├── extensions.py     # initializes the extensions
          ├── models.py         # database models
          ├── my_module/
          └── static/
```



https://github.com/sdg32/flask-celery-boilerplate/blob/master/app/schedule/extension.py



### 1. Use Application Factories

- Delays configuration until WSGI server is started (secure, dynamic configuration files)
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

> *Rather than referring to an app directly, you use the the* **current_app** *proxy, which points to the application handling the current activity.*

```python
from flask import current_app
current_app.config['RELEVANT_CONFIG_VARIABLE']
```



### 2. Modular configurations

**Configure the application**

```python
def create_app(config_object_name) -> Flask:
    app = Flask(__name__, instance_relative_config=False)
    app.config.from_object(config_object_name)
    return app
```

**Defining Configurations**

- Don't set `ENV` , use the environment variable `FLASK_ENV`
- Derive all app configuration values from a class or environment variables.

config.py

```python
class DefaultConfig(object):
    DEBUG = True
```

run.py

```python
from app import create_app
app = create_app('config.DefaultConfig')
if __name__ == "__main__":
    app.run(host='0.0.0.0', port=80)
```



### Extensions

- instantiate globally in `__init__.py`
- setup in application factory using `init_app()` (allows to configure extension after import when wsgi is initialized)

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



**Example:** Wrapping Celery for post-import configuration

```python
class FlaskCelery:
    """Flask celery extension."""

    celery = None  # type: Celery
    flask = None   # type: Flask

    def __init__(self, name: str, app: Flask = None):
        self.celery = Celery(name)
        self.flask = app

        if app is not None:
            self.init_app(app)

    def init_app(self, app: Flask):
        self._load_config(app)

        if not hasattr(app, 'extensions'):
            app.extensions = {}

        class ContextTask(BaseTask):
            def __call__(self, *args, **kwargs):
                with app.app_context():
                    return super().__call__(*args, **kwargs)

        self.celery.task_cls = ContextTask
        app.extensions['celery'] = self

    @property
    def task(self):
        return self.celery.task

    def _load_config(self, app: Flask):
        """Load config from flask."""
        for k, v in app.config.items():
            if not k.startswith('CELERY_'):
                continue
            self.celery.conf[k[7:].lower()] = v
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







## Full Example



**/config.py**

```python
class Config(object):
    DEBUG = False
    TESTING = False
    # ... some exention specific settings

class ProductionConfig(Config):
    pass

class DevelopmentConfig(Config):
    DEBUG = True
```

**/app/extensions.py**

- store the extensions object globally
- get registered using `db.init_app(app)` in the application factory

```python
from flask_sqlalchemy import SQLAlchemy
from flask_migrate import Migrate

# setup database
db = SQLAlchemy()
# setup migration script
migrate = Migrate()
```

**/app/routing.py**

```python
def register_routes(app):
    @app.route('/')
    def hello_world():
        return 'Hello, World!'
```

**/app/\__init\___.py**

- initialize database within application context

```python
from flask import Flask
from .extensions import db, migrate
from .routing import register_routes


def init_extensions(app: Flask):
    db.init_app(app)
    migrate.init_app(app, db)


def create_app(config_object_name) -> Flask:
    """
    :param config_object_name: The python path of the config object.
                               E.g. appname.settings.ProdConfig
    """
    # Initialize the core application
    app = Flask(__name__, instance_relative_config=False)
    # Initialize Plugins using init_app()
    init_extensions(app)
    # Load the configuration
    app.config.from_object(config_object_name)
    with app.app_context():
        # Register Blueprints
        register_routes(app)
        # Create tables for our models
        db.create_all()
        return app
```

