# Modern Javascript

**ECMAScript 5**

- 2009: Introduction of ECMAScript 5 (ES5), added new features to language and modified existing ones
- To enable new features, add `"use strict"` at top of script





**Resources**

- https://javascript.info/



## Do's/Don'ts

- case sensitive: Upper/lowercase


# ECMA Script 6



#### Destructuring

**Arrays**
```javascript
var a, b, rest;
[a, b] = [10, 20];
[a, b, ...rest] = [10, 20, 30, 40, 50];
```

**Objects**

```javascript
var o = {p: 42, q: true};
// basic assignent
var {p, q} = o;
// assignment without declaration
var a, b;
({a, b} = {a: 1, b: 2});
let {a, b, ...rest} = {a: 10, b: 20, c: 30, d: 40}
```


**From Function Arguments**

```javascript

var user = {
  id: 42,
  displayName: 'jdoe',
  fullName: {
      firstName: 'John',
      lastName: 'Doe'
  }
};
function userId({id}) {
  return id;
}

function whois({displayName, fullName: {firstName: name}}) {
  console.log(displayName + ' is ' + name);
}

```



## Imports

**Import default export**

```javascript
import moduleName from 'module'
```

**Import named export**

```javascript
import { destructuredModule } from 'module'
```



## Variables

- `let`
- `const`
- `var`
  -  **old**, has **no block scope!** (variables only limited to functional scope)
  - declaration at beginning of function start
  - assignment at actual position

## Data Types

### Strings

```javascript
let single = 'single-quoted';
let double = "double-quoted";
let backticks = `backticks`;
```

**Evaluation in strings**

```javascript
let my var = `1 + 2 = ${sum(1, 2)}.`;  // 1 + 2 = 3.
```



## Functions

**Anonymous Function**

```javascript
(params) => { }
```

**Named Function**

```javascript
const functionName = (params) => { }
```



## Iteration

**For each** (Array)

```javascript
arrayName.forEach(element => { })
```

**For of** (Array)

```javascript
for(let itemName of objectName) { }
```

**For in**  (Objects)

```javascript
for(let key in objectName) { }
```



## OOP