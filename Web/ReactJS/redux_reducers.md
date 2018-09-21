# Redux State Reducers

## Slicing Reducers


- `combineReducers` creates nested state
	- problems with state sharing between reducers
	- each reducer manage own slice of state (e.g. state.todos and state.logging). This is useful when creating a root reducer.
- `reduceReducers` creates flat state
	- cluttered state updates
	- each reducer manage the same state. This is useful when chaining several reducers which are supposed to operate over the same state


#### `combineReducers`
- manage subset (property) of the state
- root reducer will be keyed - **independent of global state**
- **Problem:** No exchange between reducers

```javascript
import { combineReducers } from "redux";
import notes from "./notes";

// Combine reducers
export default combineReducers({
  notes
});
```

Equals to:

```javascript
function rootReducer(state = {}, action) {
  return {
    notes: apples(state.notes, action),
  };
};
```



## Sharing State between Reducers

**Your options:**
- don’t use combineReducers (write your own that shares state/selector between two components)
- use `thunk` middleware
- pass selectors on global store through all your actions
- call window.store.getState().myreducer.myvalue directly to get the state (worst option)
