# Modern Javascript

**ECMAScript 5**

- 2009: Introduction of ECMAScript 5 (ES5), added new features to language and modified existing ones

- To enable new features, add `"use strict"` at top of script. Automatically added if classes/modules are used.

  ```javascript
  "use strict";
  
  // this code works the modern way
  ...
  ```

  



## Basics

- `;` at end of line optional



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





## JavaScript Fundamentals



### Imports

**Import default export**

```javascript
import moduleName from 'module'
```

**Import named export**

```javascript
import { destructuredModule } from 'module'
```



### Variables and Scope

- `let` 
  - block scope (`{}`)
  - access before assignment: throws `RefrenceError`
- `const`
  - block scope (`{}`)
  - access before assignment: throws `RefrenceError`
  - can't be reassigned (but not bit constess!)
- `var` 
  - function scope
  - access before assignment: `undefined`



### Data Types

- `typeof()` derive object type
- use `===` for strict evaluation (prevent type conversion)

**Primitives**

- `number` numbers of any kind (integer/float), limited to 64bit
- `bigint` numbers of arbitrary size
- `boolean`
- `string` for strings
  - including empty
  - no special type for single characters

**Object and Symbols**

- `object` collection of data
- `symbol` unique identifiers for objects

**Special Values**

- `null` 
  - reference to non-existing object/null pointer
  - represents "nothing"/"empty"/"unknown"
- `undefined`
  - "value is not assigned"
  - use `null` to assign "unknown"
- `NaN`
  - `undefined` converted to number (e.g. in zero division)



### Comparison and Assignment Operators

**Nullish coalescing operator `??`**

- conditional assignment with null check
- `a` if not `null`/`undefined`, else `b`
- returns first defined value

```javascript
result = a ?? b
```



### Control Structures



**do ... while**

```javascript
do {
  // loop body
} while (condition);
```

**for**

```javascript
for (begin; condition; step) {
  // ... loop body ...
}
```

**foreach**

```js
num.forEach(function (value) {
    
});
```

**switch**

- type matters, equality check is always strict `===`

```javascript
switch(x) {
  case 'value1':  // if (x === 'value1')
    break;
  case 'value2':  // grouping of cases
  default:
    // do something
}
```





#### Loop Labels

- break/continue to specific loop scope
- `break <labelName>`

```javascript
labelName: for (...) {
  ...
}
```

**Example:**

```javascript
outer: for (let i = 0; i < 3; i++) {
  for (let j = 0; j < 3; j++) {
    let input = prompt("Name?", '');
    if (!input) break outer; // end both loops
  }
}
```





## Data Types

### Strings

```javascript
let single = 'single-quoted';
let double = "double-quoted";
let backticks = `backticks`;
```

**Evaluation in strings**

```javascript
let mystring = `abc  ${my_expression}`;
```

**Concatenation**







### Arrays

```javascript
let arr = new Array();
let arr = [];
```

**Methods**

- `push` / `pop` add/remove and return
- `shift` / `unshift` remove from start/end
- `slice(<start>, <end>)`
- `concat`

**Iteration**

```javascript
for (let i = 0; i < arr.length; i++)
```

```javascript
for (let elem of arr)
```

**Spread/Rest Operator**

```js
function myFunction(x, y, z) { }
var args = [0, 1, 2];
myFunction(...args);
```





### Map

- key-value container

```jsx
var map1 = new Map([[1 , 2], [2 ,3 ] ,[4, 5]]);
```

- `.has(key)`
- `.get(key)`
- `.clear()`
- `.set("key_value", "value"); `
- `keys()`





## Functions

- value representing action
- can be assigned to variables

```javascript
// declaration
function sayHi() {}
// expression
let sayHi = function() {};
```

**Default arguments**

```javascript
function sum(a=1, b=2) {}
```

**Arrow Functions**

- `let func = (arg1, arg2, ...argN) => expression`

```javascript
// single line
let sum = (a, b) => a + b;
// multi-line
let functionName = (params) => { };
```

**Anonymous Function**

- e.g. used as callback/event handlers

```javascript
(params) => { }
```



### Iteration

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

### Array Manipulation

**Filtering**

```javascript
myArray.filter(word => word.length > 6);
```

**Re-Mapping**

```javascript
const new_array = array1.map(x => x * 2);
const new_array = todos.map((todo, index) => {});
```



## Objects

- `const` objects **can** be changed!
- property ordering:
  - integers are sorted
  - others: declaration order



### Definition

```javascript
// "object constructor" syntax
let user = new Object(); 
// "object literal" syntax
let user = {};
// direct property assignment
let user = {
  name: "John",
  age: 30
};
// shorthand initialization (in case property name == value)
let user = {
    name,  // same as name:name
    age: 30
}
```

### Property Access

**Access**

- `obj.property`.
-  `obj["property"]`
-  `obj[varWithKey]`

**Delete Operator**

- `delete user.name`

**Property Existence**

- `object.key !== undefined`
- `"key" in object`
- `for (let prop in obj)`

**Optional Chaining**

- On property: `value?.prop`
  - returns `prop` if value exists
  - can be chained: `user?.address.street`

- On method: `obj.method?.()`
  - calls method if it exists, otherwise returns `undefined`



### References and Copies

- assignment **by reference**, not copy by default
- use `===` to check for reference equality

**Cloning**

- `Object.assign(dest, [src1, src2, src3...])`
- instead of copying attributes individually
- overwrites if property exists
- does not apply to **nested** objects (check type of each attribute)

**Example:** Copy properties

```javascript
let user = { name: "John" };
// copies all properties of "permissions" to user
Object.assign(user, permissions);
```

**Example:** Clone object

```javascript
let clone = Object.assign({}, user);
```

### Object Methods

- use `this` (evaluated at runtime) to access members

**Declaration**

```javascript
user = {
    name: "John"
    // use 
    sayHi() {
        alert(this.name);
    }
}
```



### Symbols

- Symbols are guaranteed to be unique
- can be used as **property keys** (instead of strings)
- are **skipped** in `for ...in` loops
- to string: `id.toString()`

```javascript
let id1 = Symbol("description");
let id2 = Symbol("description");

let user = {
  [id]: 123
};
```

#### Global Symbols

- global registry to store symbol by name

**Lookup**

```javascript
let globalSymbol = Symbol.for("name");
```



## File Handling

**Image Loading Promise**

```javascript
const loadImage = url => {
  return new Promise((resolve, reject) => {
    let img = new Image();
    img.addEventListener('load', e => resolve(img));
    img.addEventListener('error', () => {
      reject(new Error(`Failed to load image's URL: ${url}`));
    });
    img.src = url;
  });
};

loadImage(url).then(img => {
    const width = img.naturalWidth;
    const height = img.naturalHeight;
    const src = img.src;
});
```

### Object URLs

- `window.URL.createObjectURL` to creates a **reference** url to a `File` or `Blob`

- `window.URL.revokeObjectURL(url)` to free up memory (url lifetime is tied to the `document` of the window)

```javascript
var img_src = window.URL.createObjectURL(file_object);
```

Usage:

```javascript
var fileInput = document.querySelector('input[type="file"]');
var preview = document.getElementById('preview');
fileInput.addEventListener('change', function(e) {
    var url = URL.createObjectURL(e.target.files[0]);
    preview.setAttribute('src', url);
});
```

### Base64 Encoding

- embedding of file data in url

```javascript
getBase64(file_object, imageUrl =>
    do_something(imageUrl);
);
```



