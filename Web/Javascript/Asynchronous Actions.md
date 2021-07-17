# Asynchronous Actions

https://javascript.info/async



## Promises

- `Promise` object represents the eventual completion or failure of an asyc action

![promises](img\promises.png)



**Defining a Promise**

- `resolve(value)` if the job is finished successfully, with result `value`.
- `reject(error)` if an error has occurred, `error` is the error object.
- Only the first `resolve`/`reject` will be called - Promise can have only a single state change (internal)

```javascript
function fetchData() {
    return new Promise((resolve, reject) => {
          // do some async work
          if (/* everything turned out fine */) {
            resolve("Stuff worked!");
          } else {
            reject(Error("It broke"));
         }
    })
}
```

### Consumers: then, catch, finally

**Then**

- define both success and error handler

```javascript
fetchData().then(
  result => alert(result), // "result" contains arguments passed to "resolve"
  error => alert(error) // "error" contains arguments passed to "reject"
);
```

**Catch**

- if only interested in error

```tsx
promise.catch(error => {});
// same as:
promise.then(null, f)
```

**Finally**

- `finally` runs at end of promise. Success/failure does not matter.

```tsx
fetchData()  
// runs when the promise is settled, doesn't matter successfully or not
.finally(() => stop loading indicator)
// so the loading indicator is always stopped before we process the result/error
.then(result => show result, err => show error)
```



## Promises Chaining

- chained `then` are synchronized and pass results to each other
- handlers are FIFO queued
- `then` can also retrun a new promise



```tsx
my_promise()
.then(v => {})
.then(v => {})
.then(v => {})
```



## Async Await



#### Async Functions

- `async` keyword to automatically return a Promise
- `return` statement is used as the `resolve` value of the returned promise

```tsx
async function f() {
  // same as:
  // return Promise.resolve(1);
  return 1;
}
```

**With arrow function**

```tsx
const foo = async () => {}
```

```tsx
const foo = async arg => {}
```

```tsx
const foo = async (arg1, arg2) => {}
```

**In a callback**

```tsx
const foo = event.onCall(async () => {
  // do something
})
```





1. To **set** the resolution value of the promise created by the `async` function, you have to use a `return` statement from the `async` function itself. Your code has a `return` in the `getJSON` callback (which is ignored), not the `async` function itself.
2. To **get** the resolution value of an `async` function, you must `await` it (or consume its promise in the older way, via `then`, etc.).





#### Await

- `await` keyword suspends function execution until promise is resolved and returns the result
- consumes the promise as an alternative to `promise.then` and returns the resolution value
- **only works in `async ` methods**

```tsx
// works only inside async functions
let value = await promise;
// "value" can now be accessed, "await" blocks
console.log(value);
```





#### Async Class Methods

```tsx
class Waiter {
  async wait() {
    return await Promise.resolve(1);
  }
}
```



## Parallel Execution of Promises

-  see https://javascript.info/promise-api

```tsx
let promise = Promise.all([...promises...]);
```



```tsx
// wait for the array of results
let results = await Promise.all([
  fetch(url1),
  fetch(url2),
  ...
]);
```





## Examples





