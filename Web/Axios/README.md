# Axios







```javascript

axios.post('/user', {
    firstName: 'Fred',
    lastName: 'Flintstone'
  })
  .then(function (response) {
    console.log(response);
  })
  .catch(function (error) {
    console.log(error);
  });
```





## CORS

**CORS**

- requests are stopped by browser, when site (e.g. app.example.com) is trying to send a request to a separate origin, e.g. (api.example.com)

**Problem 1:** Authorization headers

- browser sends pre-flight OPTIONS call before GET/POST requests (e.g. authorization headers)
- solution: configure server to respond to OPTIONS requests





## Flask - Server-Side CORS

**Error**

>  Response to preflight request doesn't pass access control check: No  'Access-Control-Allow-Origin' header is present on the requested  resource. Origin 'http://localhost:3000' is therefore not allowed access. 



**Initialzation**

```python
app = Flask(__name__)
cors = CORS(app)
```

#### Route Specific CORS

**Specifying the route**

- passed through `resources` argument

```python
app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

@app.route("/api/v1/users")
def list_users():
  return "user example"
```

**Via Decorator**

```python
@app.route("/")
@cross_origin()
def helloWorld():
  return "Hello, cross-origin-world!"
```

