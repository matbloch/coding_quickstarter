# Structure Mapping







### Destructuring

```tsx
const user = { 
    'name': 'Alex',
    'address': '15th Park Avenue',
    'age': 43
}
const { name, age, salary=123455 } = user;
```



**Aliases**

```tsx
const user = { 
    'name': 'Alex',
    'address': '15th Park Avenue',
    'age': 43
}

const { address: permanentAddress } = user;
```



**nested object destructuring**



**destructuring from variable name**

```tsx
var object = { item: { a: 'a0', b: 'b0' } },
    key = 'b',
    value;

({ [key]: value } = object.item);
```







### Structure Mapping



- `Object.keys(<the-object>)`

- 



**Remove property of object**

```jsx
const {salary, ...rest} = current;
return rest;
```



```jsx
// 👇️ create copy of state object
const copy = {...current};
// 👇️ remove salary key from object
delete copy['salary'];
return copy;
```









### Examples









**Render properties of object**





**Render elements in array**

```tsx
function App() {
  return (
    <div>
      {data.map(((item) => (
        <div key={item.id} className="post">
          <h3>{item.title} - {item.id}</h3>
          <p>{item.body}</p>
        </div>
      )))}
    </div>
  );
}
```

