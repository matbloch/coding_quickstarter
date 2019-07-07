# Async Actions



- axios -- npm module that helps in consuming our 3rd party apis
- redux-thunk -- redux middleware for asynchronous actions

`npm install --save axios redux-thunk`

### Redux-Thunk

- allows you to write action creators that return a function instead of an action (=thunk)
- Allows to perform async actions


**Thunk action creator**
```javascript
function makeAjaxCall(someValue) {

  // Invert control!
  // Return a function that accepts `dispatch` so we can dispatch later.
  // Thunk middleware knows how to turn thunk async actions into actions.
    return (dispatch, getState) => {
        dispatch({type : "REQUEST_STARTED"});
        
        myAjaxLib.post("/someEndpoint", {data : someValue})
            .then(response => dispatch({type : "REQUEST_SUCCEEDED", payload : response})
            .catch(error => dispatch({type : "REQUEST_FAILED", error : error});    
    };
}
```

**Calling Actions:** inside component
```javascript
componentDidUpdate(prevProps) {
if (prevProps.forPerson !== this.props.forPerson) {
  this.props.dispatch(
    makeASandwichWithSecretSauce(this.props.forPerson)
  );
}
}
```

**Calling Actions:** with `mapDispatchToProps`
```javascript
function asyncActionCreator () {
  return (dispatch, getState) => {
    dispatch(someAction());

    someAsyncStuff().then(() => {
      dispatch(someOtherAction(getState().foo);
    });
  }
}

function mapDispatchToProps(dispatch) {
  return {
    foo: () => dispatch(asyncActionCreator())
  }
}
```

## Axios

**Response Schema**
```json
{
  // `data` is the response that was provided by the server
  data: {},

  // `status` is the HTTP status code from the server response
  status: 200,

  // `statusText` is the HTTP status message from the server response
  statusText: 'OK',

  // `headers` the headers that the server responded with
  // All header names are lower cased
  headers: {},

  // `config` is the config that was provided to `axios` for the request
  config: {},

  // `request` is the request that generated this response
  // It is the last ClientRequest instance in node.js (in redirects)
  // and an XMLHttpRequest instance the browser
  request: {}
}
```


# CORS



- Cross-Origin Resource Sharing (CORS) is a specification that prevents JavaScript from making requests across domain boundaries



**Solution**

- Modify server to accept request from a different origin



`Access-Control-Allow-Origin: http://localhost:3000`



or 

`Access-Control-Allow-Origin: *`