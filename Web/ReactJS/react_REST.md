# API calls with React.js



- axios -- npm module that helps in consuming our 3rd party apis
- redux-thunk -- redux middleware for asynchronous actions

`npm install --save axios redux-thunk`

### Thunks

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