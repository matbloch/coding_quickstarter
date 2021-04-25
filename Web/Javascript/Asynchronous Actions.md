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
promise.catch(alert);
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
- `then` can also retrun a new promise



```tsx
my_promise()
.then(v => {})
.then(v => {})
.then(v => {})
```





## Parallel Execution

-  see https://javascript.info/promise-api

```tsx
let promise = Promise.all([...promises...]);
```



## Async Await