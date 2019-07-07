# Event Listeners on React Components





## Window Events



**Naive Implementation**

- event lists grow too long - thread activity will be high

```javascript
handleResize = (e) => {
    ...
}
componentDidMount() {
   window.addEventListener('resize', this.handleResize)
}

componentWillUnmount() {
   window.removeEventListener('resize', this.handleResize)
}
```

**Alternative Implementation**

- publish/subscribe pattern
- See also [this article](https://hackernoon.com/do-you-still-register-window-event-listeners-in-each-component-react-in-example-31a4b1f6f1c8)