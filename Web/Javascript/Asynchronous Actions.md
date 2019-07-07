# Asynchronous Actions



## Promises

- `Promise` object represents the eventual completion or failure of an asyc action

![promises](img\promises.png)



**Defining a Promise**

```javascript
function fetchData() {
    return new Promise((resolve, reject) => {
          if (/* everything turned out fine */) {
            resolve("Stuff worked!");
          }
          else {
            reject(Error("It broke"));
          }
    })
}
```

**Handling the result/error**

```javascript
fetchData().then((result) => {
    console.log(result);
}, (err) => {
    console.log(err);
});
```





## Async Await