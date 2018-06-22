# ReactJS

**Limitations**
- Covers only view of the app




## Setup Development Environment
- React is built with JSX, a mix of Javascript and HTML
- Needs preprocessor (Babel) to compile JSX into JS

**Babel**



## Getting Started

### Components
- Built around **components** not templates
- `createClass` creates specification object that contains all methods of component
- Render function is UI description at any given time. Content will be updated automatically.


```js
var ButtonForm = React.createClass({
    render: function(){
        return (
            <div>
                <h3>Click the button</h3>
                <input type="submit" />
            </div>
        );
    }
});

var App = React.createClass({
    render: function(){
        return (
            <div>
                <h1> Welcome to my button app!</h1>
                <ButtonForm />
            </div>
        );
    }
});


```



### Storing Data

**You should...**
- keep as few stateful components as possible
- minimize amount of state data
- pass data down the hierarchy as props

#### State
- state is **mutable**
- `this.state.YOURSTATEVAR` provides access
- `this.setState({YOURSTATEVAR: VALUE})` to set new state
- `getInitialState` for set initial state values

**Note**
- `setState` is asynchronous - causes rerendering
- only use `this.state` to change state in constructor!

**Where should state live?**
- Identify every component that renders something based on that state
- Find common owner component
- State should live in common owner or higher up the hierarchy
- If no component found: Add new state component



```js
var App = React.createClass({

    getInitialState: function(){
        return {
            active: true
        }
    },

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

**Call with**

- Note: Curly brackes: JS

```js
var BUTTONTEXT = "Click the button";
<App text={BUTTONTEXT} />
```

## Inverse Data Flow
- pass down parent method to child as prop

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


### Rendering

```js
React.render(<App />,  document.getElementById("content"));
```