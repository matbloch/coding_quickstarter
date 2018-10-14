# Flask



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


#### Blueprint

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

