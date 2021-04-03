# Designing Restful Architectures

### Tools

- [Insomnia](https://insomnia.rest/)
	- Request Generation for API testing

### HTTP Methods
- `GET` get
- `POST` create
- `PUT` update/replace, sending whole entity
- `PATCH` partial update
- `DELETE` remove


### HTTP Response Codes

**`2xx` Success**
- `200` ok
- `201` created
- `204` sucess but no content (e.g. on `DELETE`)

**`3xx` Redirection**

**`4xx` Client Error**
- `400` Bad request
- `401` Unauthorized
- `403` Forbidden. Auth ok but not allowed to access this ressource
- `404` Not found
- `410` Gone

**`5xx` Server Error**
- `500` Internal server error
- `503` Service unavailable



## Request Payload



## Response Payload

- see the Google style guide: https://google.github.io/styleguide/jsoncstyleguide.xml

- Envelope data response (due to potential security risks)
	- although HTTP status code provides distinction



**Top-Level Structure and reserved properties**

- `data`: Container for all the data from a response.  This property itself has  many reserved property names, which are described below.  Services are  free to add their own data to this object.  A JSON response should  contain either a `data` object or an `error` object, but not both.  If both `data` and `error` are present, the `error` object takes precedence.
- `error`: Indicates that an error has occurred, with details about the error.  The error format supports either one or more errors returned from the  service.  A JSON response should contain either a `data` object or an `error` object, but not both.  If both `data` and `error` are present, the `error` object takes precedence
- `status`: HTTP status code

```javascript
{
  status: 200,
  data: [
    { ... },
    { ... },
    // ...
  ],
  error: {}
}
```

**Processing the Response**

```javascript
// enveloped, error extraction from payload
const { data, error } = payload

// processing errors if they exist
if (error) { throw ... }

// otherwise
const normalizedData = normalize(data, schema)
```



### Error Handling

> How to return errors in a normalized way

- MUST use HTTP status codes in 400 or 500 range
- Content-type: `application/json`





#### Option 1: Return First Error

- `error` just contains the first occurred error and it's details



Structure:

- **code:** HTTP status code
- **message**: A human-readable message, describing the error. This message MUST be a  description of the problem NOT a suggestion about how to fix it.  If there are multiple errors, `message` will be the message for the first error.

- **errors** (optional): An array that contains individual instance(s) of the error. 
  - `message`
  - `reason` (optional): Unique identifier for this error.  Different from the `error.code` property in that this is not an http response code.

```json
{
  "error":{
    "code": 500,
    "message": "Internal Error",
    "identifier": "ai2b82asadf823r",  # optional
    "errors": [
    	{"message": "You didn't do this correctly", "reason": "INTERNAL_IDENTIFIER"}  
    ]
  }
}
```



#### Option 2: Supporting Multiple Errors

- `error` contains a dictionary or list of errors



**Example:** Field Validation

```javascript
"error": {
    "error": "FIELDS_VALIDATION_ERROR",
    "description": "One or more fields raised validation errors."
    "fields": {
      "email": "Invalid email address.",
      "password": "Password too short."
    }
}
```

**Example:** Request Error

```javascript
"error": {
    "error": "EMAIL_ALREADY_EXISTS",
    "description": "An account already exists with this email."
}
```



### Success Handling



#### Embedding Many-to-Many Relationships

> Deciding on the depth of the returned data

- encode relationships as URLs

**References vs Embedding**

- references: encode relationships as URLs
- embeddings: auto-load related resources
  - can easily result in an "N+1 select issue"



## Endpoint Design

- don't include *action* in endpoint
- use Plurals
- Avoid unneccessary query strings (e.g. rather `/projects/:id/collections` than `/collections?projectId=:id`)

#### Example

**Root Endpoint** `/companies`
- `GET` `/companies` Get list of all companies
- `GET` `/compoanies/14` Get company by id
- `DELETE` `/compoanies/14` Delete company by id

**Child Node** `employees`
- `GET` `/companies/14/employees` Get list of all employees for company with specific id
- `GET` `/compoanies/14/employees/25` Get company emplyee with id 25
- `DELETE` `/compoanies/14/employees/25` Delete specific employee

**Handling Relationships**
If relation can exist independently of resource: add separate entpoint
- `GET` `/tickets/12/messages` Retrieves list of messages for ticket #12
- `GET` `/tickets/12/messages/5` Retrieves message #5 for ticket #12
- `POST` `/tickets/12/messages` Creates a new message in ticket #12
- `PUT` `/tickets/12/messages/5` Updates message #5 for ticket #12
- `PATCH` `/tickets/12/messages/5` Partially updates message #5 for ticket #12
- `DELETE` `/tickets/12/messages/5` Deletes message #5 for ticket #12




### Misc Tipps
- Use API versioning, prefix all urls. E.g. `GET www.myservice.com/api/v1/posts`
- If API placed at different subdomain, you need to implement **Cross-Origin Resource Sharing** (CORS) 