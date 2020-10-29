# Modules



- `export` make accessible from outside
- `import` import functionality
- module-level scope: modules have their own scope (variables/methods are not seen from outside)

### Export

- no semicolon after export of method/class

```js
// earray
export let months = ['Jan', 'Feb', 'Mar','Apr', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
// constant
export const MODULES_BECAME_STANDARD_YEAR = 2015;
// class
export class User {
  constructor(name) {
    this.name = name;
  }
}
```

```js
// separate export
export {months, User};
```

**Default Export**

- `export default`
- allows import without `{}`, `import User from user.js`

```js
export default class User {}
```



### Import

- Named exports from module: 
  - `import {x [as y], ...} from "module"`
- Default export: 
  - `import x from "module"`
  - `import {default as x} from "module"`
- Everything: 
  - `import * as obj from "module"`
- Import the module (its code runs), but do not assign it to a variable: 
  - `import "module"`



