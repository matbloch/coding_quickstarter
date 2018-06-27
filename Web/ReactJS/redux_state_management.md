# Redux State Management


## Normalizing the State
**Benefits**
- flat hirarchy:
	- prevent unnecessary rerendering on object update
	- prevent unnecessary state copying
	- prevent duplicate information


**Key Elements**
- order stored in `allIds`
- store information `byId` and additionally `id` in object

## Update Patterns

**Copying the State**

```javascript
const object1 = {a: 1,b: 2,c: 3};
const object2 = Object.assign({c: 4, d: 5}, object1);
```

**Arrays: Add object**
```javascript
case ADD_TODO:
  return Object.assign({}, state, {
    todos: [
      ...state.todos,	// copy the todo values
      {
        text: action.text,
        completed: false
      }
    ]
  })
```

**Arrays:** Functional Operation
- use `<Array>.map((item, index) => {...})` (non-mutating)

```javascript
case TOGGLE_TODO:
  return Object.assign({}, state, {
    todos: state.todos.map((todo, index) => {
      if (index === action.index) {
        return Object.assign({}, todo, {
          // toggle value
          completed: !todo.completed
        })
      }
      return todo
    })
  })
```

**Arrays:** Remove by index
- use `findIndex` with item comparison method
```javascript
case "REMOVE_ITEM": {
  // Find index of item with matching ID and then
  // remove it from the array by its' index
  const index = state.findIndex(x => x.id === action.id);
  return [...state.slice(0, index), ...state.slice(index + 1)];
}
```

**Arrays:** Add item at index
- use `findIndex` with item comparison method
```javascript
case "ADD_ITEM": {
    return [
        ...state.slice(0, action.index),
        action.item,
        ...state.slice(action.index)
    ];
}
```

**Arrays:** Add item
```javascript
case ADD_ITEM :
    return { 
        ...state,
        arr: [...state.arr, action.newItem]
    }
```

**Arrays:** Update specific item

```javascript
function updateObjectInArray(array, action) {
    return array.map( (item, index) => {
        if(index !== action.index) {
            // This isn't the item we care about - keep it as-is
            return item;
        }
        
        // Otherwise, this is the one we want - return an updated value
        return {
            ...item,
            ...action.item
        };    
    });
}
```

**Arrays:** Filtering

```javascript
function removeItem(array, action) {
    return state.filter( (item, index) => index !== action.index);
}
```

**Updating Nested Data**
- updating `state.first.second[someId].fourth`
- watch out for shallow copies!
```javascript
function updateVeryNestedField(state, action) {
    return {
        ...state,
        first : {
            ...state.first,
            second : {
                ...state.first.second,
                [action.someId] : {
                    ...state.first.second[action.someId],
                    fourth : action.someValue
                }
            }
        }
    }
}
```

**Object** Remove Key
```javascript

```

