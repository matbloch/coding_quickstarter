# Typescript

- based on "duck typing"



**Features**

- hard typing
- type inference
- interfaces
- type aliasing
- additional types: any, void, enums, tuple, ...
- shorthands
- ...





## Project Setup

#### Sample Project









#### Import System





#### Modules

- if `.ts` file uses `import`/`export`, it becomes a module
- else it's a global script







## Type Annotation

- use **lowercase** basic type names



### Variables

```javascript
let my_var: string = "abc";
```

### Methods

```tsx
function getUser(name: <ArgumentType>): <ReturnType> {}
getUser = (name: <ArgumentType>): <ReturnType> => {}
```

De-structured arguments

```tsx
const method = ({ pretty }: { pretty: boolean }): <ReturnType> => {}
```



### Aliasing and Templating

```javascript
type StringArray = Array<string>;
type ObjectWithNameArray = Array<{ name: string }>;
```

**Templated Annotation**

```javascript
interface Backpack<Type> {
  add: (obj: Type) => void;
  get: () => Type;
}
declare const backpack: Backpack<string>;
```

**Composing Types**

```javascript
type LockStates = "locked" | "unlocked";
type OddNumbersUnderTen = 1 | 3 | 5 | 7 | 9;
```



### Type Assertions / Casting

```tsx
let strLength: number = (someValue as string).length;
let strLength: number = (<string>someValue).length;
```



## Defining Types

### Array

```tsx
let list: number[] = [1, 2, 3];
let list: Array<number> = [1, 2, 3];
```

### Tuple

```tsx
let x: [string, number] = ["hello", 10];
```

### Enum

- assigned value starts at `0`

```tsx
enum Color {
    Red,
    Green,
    Blue
}
let c: Color = Color.Green;
```

**Enum Flags**

```tsx
enum Traits {
    None = 0,
    Friendly = 1 << 0, // 001 -- the bitshift is unnecessary, but done for consistency
    Mean = 1 << 1,     // 010
    Funny = 1 << 2,    // 100
    All = ~(~0 << 3)   // 111
}
```

- combination: `Traits.Mean | Traits.Funny`
- individual test: `if((traits & Traits.Mean) === Traits.Mean)`
- in: `traits & Traits.Funny`
- not in: `traitsThatAreNotFunny = traits & ~traits.Funny`
- remove flag: `traits &= ~traits.Funny`

### Maps

- es6

```js
const shorterMap: Record<string, string> = {
    foo: "1",
    bar: "2"
}
```



### Nested Types

```tsx
export interface Item {
    id: number;
    size: number;
}

export interface Example {
    name: string;
    items: {
        [key: string]: Item
    };
}
```



### Special Types

**Unknown**

```tsx
let notSure: unknown = 4;
notSure = "maybe a string instead";
```

**Any**

```tsx
let looselyTyped: any = 4;
```

**Void**

- opposite of `any`, used in function returns

  ```js
  insert = (item: string): void => {}
  ```

**Never**

- return type of function that have no reachable end



### Utility Types

- see https://www.typescriptlang.org/docs/handbook/utility-types.html



## Interfaces

> JS is duck-typed. Interfaces allow to define a contract between components.



```tsx
interface Animal {
  name: string;
}
```

```tsx
// extension
interface Dog extends Animal {
  breed: string;
}
```



### Object Interfaces

- optionals: indicated with `?`
- read-only flagged with `readonly`

```tsx
interface SquareConfig {
        name: string;
      color?: string;
      width?: number;
  readonly x: number;
}
```

### Array Interfaces

**Read-only Array**

- typed with `ReadonlyArray`

```tsx
let ro: ReadonlyArray<number> = [1, 2, 3, 4];
```

**Custom read-only Array**

```tsx
interface ReadonlyStringArray {
  readonly [index: number]: string;
}

let myArray: ReadonlyStringArray = ["Alice", "Bob"];
```

### Function Types

```tsx
interface SearchFunc {
  (source: string, subString: string): boolean;
}
```

### Class Types

- use `implements` keyword to specify interface

```tsx
// interface
interface ClockInterface {
	currentTime: Date;
	setTime(d: Date): void;
}

// actual implementation
class Clock implements ClockInterface {
  currentTime: Date = new Date();
  setTime(d: Date) {
    this.currentTime = d;
  }
  constructor(h: number, m: number) {}
}
```



### React Types

**Functional Component**

```js
interface YourProps {
    children: ReactNode // the wrapped jsx elements
    store: TodoStore
}
const yourComponent: React.SFC<YourProps> = props => {}
```



**Class Components**

```jsx
type MyProps = {
  // using `interface` is also ok
  message: string;
};
type MyState = {
  count: number; // like this
};
class App extends React.Component<MyProps, MyState> {
  state: MyState = {
    // optional second annotation for better type inference
    count: 0,
  };
  render() {
    return (
      <div>
        {this.props.message} {this.state.count}
      </div>
    );
  }
}
```





## Utility Types



#### `Partial<T>` and `Required<T>`

```tsx
interface Todo {
    title: string;
    description: string;
}

function updateTodo(todo: Todo, fieldsToUpdate: Partial<Todo>): Todo {
    return { ...todo, ...fieldsToUpdate };
}
```



## Union and Intersection of Types

- `|` for union
- only allows operations/properties that are present in **both** types



**Example:** Different types

```tsx
function printId(id: number | string) {
  console.log(id.toUpperCase());
  //Property 'toUpperCase' does not exist on type 'string | number'.
  //   Property 'toUpperCase' does not exist on type 'number'.
}
```

**Example:** different values

```tsx
function printText(s: string, alignment: "left" | "right" | "center") {}
```





## Decorators

- see https://www.typescriptlang.org/docs/handbook/decorators.html





## Mixins

https://www.typescriptlang.org/docs/handbook/mixins.html







## Types for Internal Code

> `.d.ts` should only be used to add types for external libraries. For internal usage, use import with shorthands.



src/typings/index.ts

```tsx
export type Optional<T> = T | null
```

tsconfig.json

```json
...
"paths": {
    "types": [".src/typings/index.ts"]
}
...
```

my_file.ts

```tsx
import {Optional} from 'types'
```





## Types for External Code

> **Ambient Types** allow to write type declaration for existing code/js packages.

- `.d.ts` contain declarations (won't produce .js files)
- **Don't** use `.d.ts` for your own code! Use plain `.ts` files instead.



#### **DefinitelyTyped / `@types`**

> Community-sourced type repository for many projects. Available as npm packages.

```bash
npm install --save-dev @types/react
```



#### Declaring types for existing modules

- https://drag13.io/posts/custom-typings/index.html





## Examples



#### Easy Class Initialization

- `DataOnly` type extracts only data fields from a type to require non-optional arguments automatically
- `Object.assign` allows to copy all properties in a single call

```tsx
// based on : https://medium.com/dailyjs/typescript-create-a-condition-based-subset-types-9d902cea5b8c
type FilterFlags<Base, Condition> = { [Key in keyof Base]: Base[Key] extends Condition ? never : Key };
type AllowedNames<Base, Condition> = FilterFlags<Base, Condition>[keyof Base];
type SubType<Base, Condition> = Pick<Base, AllowedNames<Base, Condition>>;
type OnlyData<T> = SubType<T, (_: any) => any>;
```



```tsx
class Person {
    public name: string = "default"
    public address: string = "default"
    // optional arguments won't be required at construction
    public age?: number = 0;
    
    // not requested in OnlyData
    doSomething =() => {}
    public constructor(init:OnlyData<Person>) {
        Object.assign(this, init);
    }
}

let persons = [
    new Person(),		// error
    new Person({}),     // error
    new Person({name:"John"}),      // error
    new Person({address:"Earth"}),  // error   
    new Person({address:"Earth", name:"John"}),  // ok
];
```

