# Redux State Reducers

## Slicing Reducers

- `combineReducers`
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



## Sharing Information between Reducers
