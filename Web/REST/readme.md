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

### Request Payload


### Response Payload
- Envelope data response (due to potential security rists)
	- altough HTTP status code provides distincition

**Response**
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

#### Many-to-Many Relationships
- encode relationships as links

**References vs Embedding**

- references: encode relationships as links
- embeddings: auto-load related resources
	- can easily result in an "N+1 select issue"


#### Error Handling

**Field Validation**
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

**Request Error**
```javascript
"error": {
    "error": "EMAIL_ALREADY_EXISTS",
    "description": "An account already exists with this email."
}
```


### Endpoints
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