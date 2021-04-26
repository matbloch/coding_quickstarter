# Error Handling

> `Error` objects are thrown when runtime errors occur. The `Error` object can also be used as a base object for user-defined exceptions. 







## Throwing and Catching Errors

```tsx
try {
  throw new Error('Whoops!')
} catch (e) {
  console.error(e.name + ': ' + e.message)
}
```



## Built-In Types







## Custom Types



```tsx
class ValidationError extends Error {
  constructor(message) {
    super(message); // (1)
    this.name = "ValidationError"; // (2)
  }
}
```

