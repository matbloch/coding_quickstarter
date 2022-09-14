# References and Hooks

> References allow to access to DOM node without modifying it's state or re-rendering it.









## Use Cases

 The [official React documentation](https://reactjs.org/docs/refs-and-the-dom.html) outlined only three possible use cases where refs are entirely considered useful for lack of better alternatives:

- Managing focus, text selection, or media playback
- Triggering imperative animations
- Integrating with third-party DOM libraries



### 01. Access value from encapsulated input













### 02. Accessing an input value



```jsx
const [title, setTitle] = useState('')
<input onChange={event => setTitle(event.target.value)} />
```



