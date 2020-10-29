# React + Redux


**File Structure**
```javascript
src/
  components/    
    ListView.js
    ListRow.js
  containers/
    ArticlesIndex.js
  services/
    articles.js
  store/
    articles/
      actions.js
      actionTypes.js
      reducer.js
    index.js
```


## Concepts

**Store**
- contains the state (of possibly multiple components)
- key-value pairs (ordinary objet)
- has no direct setter

**Actions**
- used to apply changes to the store
- applying an action = **dispatching**
- just plain objects. Usually have these attributes: `type`, `payload`
```javascript
{ type: 'ARTICLES_FETCHED'
  payload: [{
  	"id": 124,
    "title": "Learn React! Now!"
  },
  {
    "id": 513,
    "title": "Learn Redux! Now!"
  }]
}
```

**Reducers**
- Tie actions and the states (store) together
- pure function with `switch` to check for action type and return the new state of the app

**Connecting the State to Components**
- Redux provides `connect` method to automatically map the state to component properties and update the DOM
	- **Input 1:** Method that maps the state to prooperties of the component
	- **Input 2:** The component to apply the mapping to


```javascript
import React, { Component } from 'react';
import { connect } from 'react-redux';

class ArticlesIndex extends Component {
  // implementation
}

function mapStateToProps(state) {
  return {
    articles: state.articles
  }
}

export default connect(mapStateToProps)(ArticlesIndex)
```


#### The Redux Architecture

**Example:** Fetching articles from an API
- After call to API:
- Dispatch `ARTICLES_FETCHED` action (just an object) over Redux that contains the articles as payload
- Reducer checks for the action type and alters the state accordingly
- Custom state-to-prop mapper adjusts the props of the components according to the state

![redux_architexture.png](img/redux_architexture.png)

#### Putting it Together


## Advanced Structures


#### Organizing State
- Mixing local component state with redux is fine

**When add state to Redux:**
- do other parts of the application care about this data
- data shared between multiple components

**Example:** local state
- styling classes


#### Redux Store Subscriptions


#### Efficient Re-Rendering


https://redux.js.org/faq/immutable-data

#### `mapDispatchToProps`
- allows access to dispatch action directly from props
- here: directly use `this.onTodoClick` as `onClick` action
- `this.props.dispatch` is then not available anymore

```javascript
const mapDispatchToProps = (dispatch) => {
  return {
    onTodoClick: (id) => {
      dispatch(toggleTodo(id))
    }
  }
}
```

**Accessing Component Properties inside action**
```javascript
const mapDispatchToProps = (dispatch, ownProps) => ({
  onClick: () => dispatch(setVisibilityFilter(ownProps.filter))
})
```


#### Best Practices

**Naming Conventions**

- action name: `<NOUN>_<VERB>` (e.g. `TODO_ADD`)
- action creator name: `<verb><Noun>`
- selector name: `get<Noun>`


#### Updating the State through Reducers


## Presentational and Container Components
```javascript
- screens
	- Sidebar
	- List
- containers
	- ListItem
	- Select
```

**Prensentational**
- how things look
- often allow containment via `this.props.children`
	- may contain both presentational and container components
- rarely have their own state
- receive data and callbacks **exclusively** via props
- **Examples:**
	- Page
	- Sidebar
	- Story
	- Userinfo
	- List

**Container**
- How things work
- Call Flux/Redux actions and provide callbacks to presentational components
- Datafetching/state updates

## Example Components

#### Presentational Components

`Todo.js`
```javascript
import React from 'react'
import PropTypes from 'prop-types'
​
const Todo = ({ onClick, completed, text }) => (
  <li
    onClick={onClick}
    style={ {
      textDecoration: completed ? 'line-through' : 'none'
    }}
  >
    {text}
  </li>
)
​
Todo.propTypes = {
  onClick: PropTypes.func.isRequired,
  completed: PropTypes.bool.isRequired,
  text: PropTypes.string.isRequired
}
​
export default Todo
```

`TodoList.js`
```javascipt
import React from 'react'
import PropTypes from 'prop-types'
import Todo from './Todo'

const TodoList = ({ todos, onTodoClick }) => (
  <ul>
    {todos.map((todo, index) => (
      <Todo key={index} {...todo} onClick={() => onTodoClick(index)} />
    ))}
  </ul>
)

TodoList.propTypes = {
  todos: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.number.isRequired,
      completed: PropTypes.bool.isRequired,
      text: PropTypes.string.isRequired
    }).isRequired
  ).isRequired,
  onTodoClick: PropTypes.func.isRequired
}

export default TodoList
```


#### Container Components

## Examples: Migrating from Pure React


### 0. Pure React Component
- Purely component state based

```javascript
import React from 'react';

class Counter extends React.Component {
  state = { count: 0 }
  increment = () => {
    this.setState({
      count: this.state.count + 1
    });
  }
  decrement = () => {
    this.setState({
      count: this.state.count - 1
    });
  }
  render() {
    return (
      <div>
        <h2>Counter</h2>
        <div>
          <button onClick={this.decrement}>-</button>
          <span>{this.state.count}</span>
          <button onClick={this.increment}>+</button>
        </div>
      </div>
    )
  }
}

export default Counter;
```


### 1. Refactoring the Component
- connect to props:
	- define property mapping `mapStateToProps`
	- use `connect` from `react-redux`
	- define event handlers to `dispatch` state changes
	- `this.props.dispatch` to call an action


```javascript
import React from 'react';
import { connect } from 'react-redux';

class Counter extends React.Component {
  increment = () => {
    this.props.dispatch({ type: 'INCREMENT' });
  }
  decrement = () => {
    this.props.dispatch({ type: 'DECREMENT' });
  }
  render() {
    return (
      <div>
        <h2>Counter</h2>
        <div>
          <button onClick={this.decrement}>-</button>
          <span>{this.props.count}</span>
          <button onClick={this.increment}>+</button>
        </div>
      </div>
    )
  }
}

function mapStateToProps(state) {
  return {
    count: state.count
  };
}

export default connect(mapStateToProps)(Counter);
```

### 2. Define Reducers
- create index file that combines all other reducers
- in individual reducers:
	- define function with `switch` for action
	- `state` update based on action

**Notes**
- `state` is immutable (e.g. `--` won't work)

`reducers/index.js`
```javascript
import { combineReducers } from 'redux'
import counter from './counter'

export default combineReducers({
  counter
})
```

`reducers/counter.js`
```javascript
function counter(state = initialState, action) {
  switch(action.type) {
    case 'INCREMENT':
      return {
        count: state.count + 1
      };
    case 'DECREMENT':
      return {
        count: state.count - 1
      };
    default:
      return state;
  }
}
```

### 3. Initialize Store/State
- init *storage* object from *reducers* (state modification functions)
- make storage available to all container components in application (use `Provider`)

`App.js`
```javascript
import React from 'react'
import { render } from 'react-dom'
import App from './components/App'

// redux
import { Provider } from 'react-redux'
import { createStore } from 'redux'
import reducer from './reducers'

const preloaded_state = {count: 0};
const store = createStore(reducer, preloaded_state);

render(
  <Provider store={store}>
    <App />
  </Provider>,
  document.getElementById('root')
)
```



## Misc



### Dispatch after Dispatch

```javascript
export const setSkip = (skip) => {
    return (dispatch, getState) => {

        dispatch(someFunc());
        //Do someFunc first then this action, use getState() for currentState if you want
        return {
            type: 'LIST.SET_SKIP',
            skip: skip
        };
    }
};
```

### Using Ref on Connected Components

**Component**

- use `forwardRef` as forth `connect` parameter

```javascript
class FileSelector extends Component {
    myInternalFn = () => {}
}

const mapStateToProps = (state) => {
    return {};
};

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps, null, {forwardRef : true})(FileSelector);
```

**Setting up the reference**

```javascript
class Element extends Component {
    constructor(props) {
    	super(props);
        this.fileSelector = React.createRef();
    }
    
    render() {
        return (
            <div>
            	<a onClick={this.fileSelector.current.myInternalFn()}>Click me</a>
				<FileSelector ref={this.fileSelector}/>
            </div>
        );   
    }
}


```









## Redux Thunk Middleware

- async action creators

- https://devinschulz.com/combining-synchronous-actions-using-redux-thunk/

```javascript
export function getUser(id) {
  // Redux Thunk will inject dispatch here:
  return dispatch => {
    // Reducers may handle this to set a flag like isFetching
    dispatch({ type: 'GET_USER_REQUEST', id })

    // Perform the actual API call
    return fetchUser().then(
      response => {
        // Reducers may handle this to show the data and reset isFetching
        dispatch({ type: 'GET_USER_SUCCESS', id,  response })
      },
      error => {
        // Reducers may handle this to reset isFetching
        dispatch({ type: 'GET_USER_FAILURE', id,  error })
        // Rethrow so returned Promise is rejected
        throw error
      }
    )
  }
}
```



**Returning Promises from Action Creators**

```javascript
const update = (todoId, isDone) => (dispatch) =>
  new Promise(function(resolve, reject) {
    dispatch({
      type: 'SET_SAVING',
      saving: true
    });    // Function is expected to return a promise
    callUpdateApi(todoId, isDone).then(updatedTodo => {
      dispatch({
        type: 'SET_SAVING',
        saving: false
      });
      resolve(updatedTodo);
    }).catch(error => {
      // TBD: Handle errors for Redux
      reject(error);
    })
  });
```

