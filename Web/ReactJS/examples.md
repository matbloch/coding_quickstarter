# React.JS Examples




**Add Class on click**


```javascript
render(){
return(
  <div>
    <button className={this.state.active && 'active'}
      onClick={ () => this.setState({active: !this.state.active}) }>Click me</button>
  </div>
)
}
```


**Conditional Rendering**

```javascript
  render: function() {
    return ( 
      <div 
        onClick={ this.handleClick } 
        className= { this.state.condition ? "button toggled" : "button" }
      >
        { this.props.message } 
      </div>
    )    
  }
```

**Get Data of Child**
- Add `onChange` prop to child
	- call it on value change
- Implement method for `onChange` in parent (update state value)


**Conditional Function Call**
```javascript
const doThis = true;
doThis && myMethod();

```

**Inline Functions**
```javascript
class App extends Component {
  // ...
  render() {
    return (
      <div>
        
        {/* 1. an inline event handler of a "DOM component" */}
        <button
          onClick={() => {
            this.setState({ clicked: true })
          }}
        >
          Click!
        </button>
        
        {/* 2. A "custom event" or "action" */}
        <Sidebar onToggle={(isOpen) => {
          this.setState({ sidebarIsOpen: isOpen })
        }}/>
        
        {/* 3. a render prop callback */}
        <Route
          path="/topic/:id"
          render={({ match }) => (
            <div>
              <h1>{match.params.id}</h1>}
            </div>
          )
        />
      </div>
    )
  }
}
```
