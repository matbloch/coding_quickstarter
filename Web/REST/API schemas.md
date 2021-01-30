# API Schemas

- According to the Google style guide: https://google.github.io/styleguide/jsoncstyleguide.xml



## Top-Level Reserved Properties

- `data`: Container for all the data from a response.  This property itself has  many reserved property names, which are described below.  Services are  free to add their own data to this object.  A JSON response should  contain either a `data` object or an `error` object, but not both.  If both `data` and `error` are present, the `error` object takes precedence.

- `error`: Indicates that an error has occurred, with details about the error.  The error format supports either one or more errors returned from the  service.  A JSON response should contain either a `data` object or an `error` object, but not both.  If both `data` and `error` are present, the `error` object takes precedence



## Success Handling

- Content-type: `application/json`

```json
{
  "data": {
    "id": 1001,
    "name": "Wing"
  }
}
```

### Content

- **status:** HTTP status code



## Error Handling

- MUST use HTTP status codes in 400 or 500 range
- Content-type: `application/json`

```json
{
  "error":{
    "code": 500,
    "message": "Internal Error",
    "identifier": "ai2b82asadf823r",
  }
}
```



```

```





### Content

- **code:** HTTP status code
- **message**: A human-readable message, describing the error. This message MUST be a  description of the problem NOT a suggestion about how to fix it.  If there are multiple errors, `message` will be the message for the first error.

- **errors** (optional): An array that contains individual instance(s) of the error. 
  - `message`
  - `reason` (optional): Unique identifier for this error.  Different from the `error.code` property in that this is not an http response code.



## Example Python Implementation

- `Problem.valueOf(Status.NOT_FOUND)`

```json
{
  "title": "Not Found",
  "status": 404
}
```

- `Problem.valueOf(Status.SERVICE_UNAVAILABLE, "Database not reachable");`

```json
{
  "title": "Service Unavailable",
  "status": 503,
  "detail": "Database not reachable"
}
```

