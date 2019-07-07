# Event Listeners

- [List of all events](https://developer.mozilla.org/en-US/docs/Web/Events#Keyboard_Events)

- [Good article about handling events](https://eloquentjavascript.net/15_event.html)



## Keyboard Events



- `keydown` ANY key is pressed
- `keypress` ANY key (except Shift, Fn, Capslock) is pressed, fired continously
- `keyup` ANY key is released



**Key Codes**



#### Firing events only once per keypress

**Option 1:** `event.repeat`

- `repeat` is only false on very first event

**Option 2:** use `keyup`





## Throttling Event Firing

### Debouncing

- many events can fire multiple times in a row, e.g. `mousemove`, `scroll`
- Example utils library with debouncing/throttling: [Lodash](https://lodash.com/)

**Option 1: ** add blocking timeout



**Option 2:** add status boolean



#### Examples

**Waiting until a pause happens**

```javascript
  let timeout;
  textarea.addEventListener("input", () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => console.log("Typed!"), 500);
  });
```

