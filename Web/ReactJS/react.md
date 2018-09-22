# ReactJS


- React is built with JSX, a mix of Javascript and HTML
- Needs preprocessor (Babel) to compile JSX into JS

## Setup Base Project

**Prerequisites**
- Install Node.js and NPM




#### Additional Webpack Productivity Tools

**Webpack Hotloader**

**Webpack HTML**


## Random CSS

**Importing Stylesheets**
```css
@import "./variables.sass";
@import "./styles.css";
```


## Random ES6

#### Exporting

**Exporting Single Component**
```javascript
class MyClass extends Component {}
export default MyClass;
```
**Exporting Multiple Components**
```javascript
export class MyClass1 extends Component {}
export class MyClass2 extends Component {}
```

#### Importing

**Single Component**
```javascript
import Login from './login/login';
```
**Multiple Components**
```javascript
import {MyClass1, MyClass2} from './MyClass.react';
```


## Structuring a React Application

- Organizing by modules: feature first, function second

**TODO**: Add example

## Basic Bundling
- Import functionality from different files using the dynamic `import()` syntax
- Code will be bundled together in a single file by your bundler (e.g. Webpack or Browserify)
- **Code Splitting**: Bundles can become too large. Extensions can split the code into multiple bundles for "lazy-loading"

**App:**
```javascript
import { add } from './math.js';
console.log(add(16, 26)); // 42
```
**`math.js`:**
```javascript
export function add(a, b) {
  return a + b;
}
```

## JSX
- React is built with **JSX**, a mix of Javascript and HTML
- Needs preprocessor (Babel) to compile JSX into JS

**Example:** JSX Elements
```javascript
const title = <h1 id="title">my title</h1>;
const multiline = (
<div>
	<a href="google.ch">link</a>
</div>
);
```

**JSX Elements**
- can have *attributes*
- can be multi-line: encapsulate in `()`
- can be nested
- must have **exactly one outermost** html element
	- use `<React.Fragment>` to wrap
	- or an array: `[<li>a</li>, <li>b</li>]`
- can contain javascript code: wrapped in `{}`
- returning strings: wrapp in `''`, no spans needed
- Conditionals: ternary operator in javascript `<p>{is_big ? <MyComponent/> : <OtherComponent/>}</p>`
- Short circuit evaluation: `<div>{showPopup && <Popup/>}</div>`


## React Components

**Creating a Component**

- `extends React.Component`

#### Methods
- `constructor()` this is where you init the state `this.state = ...`
- your free to define other methods

```js
class Hello extends React.Component {
    constructor(){
        super();
        this.state = {
            message: "Hello world!"
        };
    }
    render() {
        return <h1>Hello {this.state.message}!</h1>;
    }
    justAnotherMethod() {
    	console.log('hi there');
    }
}
```

##### `this` inside Class Method
- Javascript methods are **not bound** by default (`this` undefined)

**Option 1:** Bind method in `constructor`

```javascript
class Toggle extends React.Component {
  constructor(props) {
    super(props);
    this.state = {isToggleOn: true};
    this.handleClick = this.handleClick.bind(this);
  }
  handleClick() {
    this.setState(prevState => ({
      isToggleOn: !prevState.isToggleOn
    }));
  }
}
```

**Option 2:** Public Class Fields Syntax (experimental)
```javascript
class LoggingButton extends React.Component {
  // This syntax ensures `this` is bound within handleClick.
  // Warning: this is *experimental* syntax.
  handleClick = () => {
    console.log('this is:', this);
  }
}
```


#### Rendering

- `render()`
	- provides UI description at any given time. Automatically updated.

**Rendering other Components**

```js
render: function() {
	return <MyOtherComponent/>;
}
```

**Children**
- `this.props.children`

```js
<AlertBox>
  <h1>You have pending notifications</h1>
</AlertBox>
```

```js
class AlertBox extends React.Component {
  render () {
    return <div className='alert-box'>
      {this.props.children}
    </div>
  }
}
```


#### Lifecycle Methods
- `componentDidMount` runs after the component output has been rendered to the DOM
- `componentWillUnmount`



## Storing Data in Components

**You should...**
- keep as few stateful components as possible
- minimize amount of state data
- pass data down the hierarchy as props

**You can...**
- also add other fields than `this.state` (just set them in constructor or on DOM load)

#### Props


- props are **immutable** - Not changeable from component
- `this.props.YOURPROP` provides access

```js
var ButtonForm = React.createClass({
    render: function(){
        return (
            <div>
                <h3>{this.props.text}</h3>
                <input type="submit" />
            </div>
        );
    }
});
```

**Passing Arrays**
```javascript
const myItems = [{ name: 'item 1' }, { name: 'item2' }];
function MyApp() {
    return (
       <TodoList items={myItems} />
    );
}
// in TodoList:
function TodoList({ items }) {
    return items.map(item => (
        <h1>{item.name}</h1>
    ));
}
```

**Passing Strings**
```javascript
<MyComponent message="hello world" />
<MyComponent message={'hello world'} />
```

**Passing Booleans**
```javascript
<MyTextBox autocomplete />
<MyTextBox autocomplete={true} />
```

**Spread Attributes**
```javascript
function App1() {
  return <Greeting firstName="Ben" lastName="Hector" />;
}
function App2() {
  const props = {firstName: 'Ben', lastName: 'Hector'};
  return <Greeting {...props} />;
}
```
**Concatenated JSX**

```javascript
const items = [1, 2, 3];
let items_jsx = [];
for (var i in items) {
	items_jsx.push(<li>{i}</li>);
}
const wrapped = <ul>{items_jsx}</ul>;
```

**Nested List**
```javascript
 list.map((item, index) => {
            return (
              <div key={index}>
                <ul >{item.value}</ul>
               {
                item.list.map((subitem, i) => {
                  return (
                     <ul ><li>{subitem.value}</li></ul>
                  )
                })
               }
              </div>
            )
          }
```

**Dict/Object Iteration**

```javascript
vals = {
  a: 1,
  b: 2,
  c: 3
}
Object.keys(vals).map((key, index) => ( 
  <p key={index}> this is my key {key} and this is my value {vals[key]}</p> 
))
```


**Conditional Attributes**
- `null`/`undefined` is often treated as if property is not set
- but might not **NOT ALWAYS**

```javascript
<Label
{...{
  text: label,
  type,
  ...(tooltip && { tooltip }),
  isRequired: required
}}
/>
```


##### Typechecking with Props

**Default Props**
```javascript
class Greeting extends React.Component {
	...
}
Greeting.defaultProps = {
  defaultValue: false
};
```

**Prop Type Definition**
- install package: `npm i prop-types --save-dev`

Choose between types:
- `PropTypes.array`
- `PropTypes.func`
- `PropTypes.bool`
- `PropTypes.element` react element
- `PropTypes.instanceOf(Message)` custom class
- ...

Make it optional/required:
- `PropTypes.{TYPE}.isRequired`

**Example**
```javascript
import PropTypes from 'prop-types';
class Greeting extends React.Component {
  render() {
    return (
      <h1>Hello, {this.props.name}</h1>
    );
  }
}
Greeting.propTypes = {
  name: PropTypes.string
};
```


#### State
- state is **mutable**

**Modifying the State**
- **get:** `this.state.YOURSTATEVAR` provides access
	- only use `this.state` to change state in constructor!
- **get initial:**`getInitialState` for initial state values
- **set:** `this.setState({YOURSTATEVAR: VALUE})` to set new state
	- merges properties (you can update values separately)
	- is asynchronous, if state dependent, use `setState((prevState, props))`, see example


**Where should state live?**
- Identify every component that renders something based on that state
- Find common owner component
- State should live in common owner or higher up the hierarchy
- If no component found: Add new state component

**State Initialization**

```js
class ExampleComponent extends Component {
  constructor() {
    super();
    this.state = {
      articles: [
        { title: "book1", id: 1 },
        { title: "book2", id: 2 }
      ]
    };
  }
}
```

**Async State Updates**

```javascript
this.setState((prevState, props) => ({
  counter: prevState.counter + props.increment
}));
```

**Example**

```js
class ExampleComponent extends Component {

	constructor() {
		this.state = {active: true};
    }

    handleClick: function(){
        this.setState({
            active: !this.state.active
        });
    },
    render: function(){
        var buttonSwitch = this.state.active ? "On" : "Off";
        return (
            <div>
                <p>Click the button!</p>
                <input type="submit" onClick={this.handleClick} />
                <p>{buttonSwitch}</p>
            </div>
        );
    }
});

```


## Data Flow
- **The data flows down**
- pass down parent method to child as prop
- `<OtherComponent myOnClickMethod={this.props.onClickMethod}/>`

```js
var ButtonForm = React.createClass({
    render: function(){
        return (
            <input type="submit" onClick={this.props.onUserClick} />
            <h3>You have pressed the button {this.props.counter} times!</h3>
        );
    }
});
```

```js
var App = React.createClass({
    getInitialState: function(){
        return {
            counter: 0
        }
    },
    onUserClick: function(){
        var newCount = this.state.counter + 1;
        this.setState({
            counter: newCount
        });
    },
    render: function(){
        return (
            <div>
                <h1> Welcome to the counter app!</h1>
                <ButtonForm counter={this.state.counter} onUserClick={this.onUserClick} />
            </div>
        );
    }
});
```

### Handling Events
- pass member method
	- remember to make `this` available

```javascript
class LoggingButton extends React.Component {
  handleClick = () => {
    console.log('this is:', this);
  }
  render() {
    return (
      <button onClick={this.handleClick}>
        Click me
      </button>
    );
  }
}
```

**Passing Arguments to Handlers**
- in both cases: `e` passed as 2nd parameter
```javascript
<button onClick={(e) => this.deleteRow(id, e)}>Delete Row</button>
<button onClick={this.deleteRow.bind(this, id)}>Delete Row</button>
```
```javascript
deleteRow = (id, e) => {
}
```

### Lists

```javascript
const numbers = [1, 2, 3, 4, 5];
const doubled = numbers.map((number) => number * 2);	// [2, 4, 6, 8, 10]
```

**Rendering Multiple Compnents**
```javascript
const numbers = [1, 2, 3, 4, 5];
// generate html
const listItems = numbers.map((number) =>
  <li>{number}</li>
);
// render html
ReactDOM.render(
  <ul>{listItems}</ul>,
  document.getElementById('root')
);
```

### Keys
- used by react to target elements and optimize element updates
- unique among siblings, not globally
- rule of thumb: elements inside the `map()` call need keys

**Definition**
```javascript
const todoItems = todos.map((todo) =>
  <li key={todo.id}>
    {todo.text}
  </li>
);
```

**Selecting Components by Keys**

**Example:** Correct Key Usage

```javascript
function ListItem(props) {
  // Correct! There is no need to specify the key here:
  return <li>{props.value}</li>;
}

function NumberList(props) {
  const numbers = props.numbers;
  const listItems = numbers.map((number) =>
    // Correct! Key should be specified inside the array.
    <ListItem key={number.toString()}
              value={number} />
  );
  return (
    <ul>
      {listItems}
    </ul>
  );
}
```
```javascript
const numbers = [1, 2, 3, 4, 5];
ReactDOM.render(
  <NumberList numbers={numbers} />,
  document.getElementById('root')
);
```


### Manual DOM Manipulation

- `React.findDOMNode(component)` to select component
- `ref` html attribute to name elements inside component
- `this.ref.YOURREFNAME` to access component by reference

```js
var ButtonForm = React.createClass({
        focusOnField: function(){
            React.findDOMNode(this.refs.textField).focus();
        },
        render: function(){
            return (
                <div>
                    <input 
                        type="text"
                        ref="textField" />
                    <input 
                        type="submit"
                        value="Focus on the input!" 
                        onClick={this.focusOnField} />
                </div>
            );
        }
    });
```

### Dynamic Component Creation
- `key` attribute needed


```js
var App = React.createClass({
    getInitialState: function(){
        return {
            todos: ["get food","drive home","eat food", "sleep"] 
        }
    },

    render: function(){
        var todos = this.state.todos.map(function(todo,index){
            return <li key={index}>{todo}</li>
        });
        return (
            <div>
                <h1> Welcome to the ToDo list!</h1>
                <ul>
                    {todos}
                </ul>
            </div>
        );
    }
});
```




## Misc Examples

**Javascript**
```javascript
import React from 'react'
import ReactDOM from 'react-dom'

class Hello extends React.Component {
  render () {
    return <div className='message-box'>
      Hello {this.props.name}
    </div>
  }
}

const el = document.body
ReactDOM.render(<Hello name='John' />, el)
```
**HTML**
```php
<html>
    <head>... react and babel includes...</head>
    <body></body>
</html>
```