# Modern Javascript

**ECMAScript 5**

- 2009: Introduction of ECMAScript 5 (ES5), added new features to language and modified existing ones

- To enable new features, add `"use strict"` at top of script. Automatically added if classes/modules are used.

  ```javascript
  "use strict";
  
  // this code works the modern way
  ...
  ```

  





**Resources**

- https://javascript.info/



## Do's/Don'ts

- case sensitive: Upper/lowercase





# ECMA Script 6



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





## OOP

**Definition**

```javascript
class Number {
  constructor(value) {
    this.value = value;
  }
}
```

**Static Members**

- **Only** static methods
- Workarounds for static variables

```javascript
...
  static add = (x, y) => {
    return x + y;
  }
...
```



**Instantiation**

```javascript
mycar = new Car("Ford");
```



**Inheritance**

- `extends` keyword

```javascript
class Model extends Car {
  constructor(brand, mod) {
    // instantiating base class
    super(brand);
    this.model = mod;
  }
  // calling the base class
  call_baseclass_method() {
    return this.method_of_base_class();
  }
}
```



### Getters and Setters

- `get` / `set`  keywords
- no parenthesis needed

```javascript
class Car {
  constructor(name) {this.carname = name;}
  get name() {return this.carname;}
  set name(x) {this.carname = x;}
}
```

```javascript
my_car_instance.name = name 
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



