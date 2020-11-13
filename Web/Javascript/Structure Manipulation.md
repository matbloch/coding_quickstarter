# Manipulating Structures





## Destructuring

> Allows to extract multiple properties of an object using a single expression 

**Property to variable**

```javascript
const { prop } = object;
```

**Multiple properties**

```js
const { prop1, prop2, propN} = object;
```

**Default value**

```js
const { prop = 'Default' } = object;
```

**Alias**

```js
const { prop: myProp } = object;
```

**Dynamic Property Name**

```js
const { [propName]: myProp } = object;
```

**Nested Object**

```js
const { nestedObjectProp: { identifier } } = expression;
```

**Rest Object**

```js
const { prop, ...rest } = object;
```

#### Function Parameter Destructuring

**ES6**

```js
my_input = {
    prop1: 123,
    prop2: "abc"
}
let myMethod = ({prop1}) => {}
```

**TypeScript**

```tsx
my_input = {
    prop1: 123,
    prop2: "abc",
    prop3: "def"
}$
let myMethod = ({prop1, prop3}:{prop1?: number, prop3: string}) => {}
```





## Spreading



### Object

**Shallow Copy**

- spread operator is handy to get shallow copy

```js
let copy = { ...original };
```

**Merge Objects**

```js
let merged = { ...foo, ...bar, ...baz };
```

**Extend / Overwrite Object**

```js
let obj = { x: 1, y: "string" };
var newObj = { ...obj, z: 3, y: 4 }; // { x: number, y: number, z: number }
```

### Array

**Extract elements**

```js
const [elem1, elem2, ...rest] = my_array;
```







## Iteration



### Object

Iterate

```js
Object.entries(obj).forEach(([key, value]) => console.log(`${key}: ${value}`));
```

Get values

```js
Object.values(obj)
```

**Object > Array**

```js
Object.keys(obj).map(function (key) { return obj[key]; });
```



## Filtering



### Array

**General filtering**

```js
this.friends.filter(friend => friend.isSingle)
```

**Remove Null/Undefined**

```js
arr.filter(n => n)
```



## Mapping



```jsx
vehicles.map(item => <TodoItem key={`${item.id}-${item.text}`} todo={item}/>)}
```

```jsx
this.state.cart.map((item) =>
    <li key={item.id}>{item.name}</li>
);
```

**Array Obj > Array new Obj**

```tsx
var result = arr.map(person => ({ value: person.id, text: person.name }));
```

**Array Obj > Array(Prop)**

```js
objArray.map(a => a.foo);
```

**Obj > Array(Prop)**

```js
Object.values(object1)
```





## Array Search

### Objects Entries

```js
myArray = [{'id':'73','foo':'bar'},{'id':'45','foo':'bar'}]
myArray.find(x => x.id === '45');
```

**Find index**

```tsx
myArray.findIndex(item => condition)
```

### Simple Values

**Includes**

```js
const alligator = ["thick scales", 80, "4 foot tail", "rounded snout"];
alligator.includes("thick scales"); // returns true
```







## Removing Items

### Arrays

**by property**

```js
items.splice(items.findIndex(function(i){
    return i.id === "abc";
}), 1);
```





## Sorting





