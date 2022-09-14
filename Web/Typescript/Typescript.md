# Typescript



**Features**

- hard typing
- type inference
- interfaces
- type aliasing
- additional types: any, void, enums, tuple, ...



## Core Principle

> TypeScript uses **structural subtyping:** aka "duck typing". Type checking focuses on *shape* rather than values. If the type is shaped like a duck, it's a duck. If a goose has all the same attributes as a duck, then it also is a duck.



#### Structural Typing and Nominal Typing

> TypeScript creates types for classes but uses **nominal** instead of **structural** typing for them.

- **Pitfall:** TS only cares about the properties of a type. If they are the same, no error is thrown.

  

**Structural Typing**

- Objects are considered equal if their properties match

```tsx
class Foo { method(input: string) { /* ... */ } }
class Bar { method(input: string) { /* ... */ } }
let foo: Foo = new Bar(); // Works!
```



**Nominal Typing**

- A nominal type system means **that each type is unique** and even if types have the same data you cannot assign across types. . E.g. featured by C++, Java, Swift.

```tsx
class Foo { method(input: string) { /* ... */ } }
class Bar { method(input: string) { /* ... */ } }
let foo: Foo = new Bar(); // Error!
```



#### Workaround for Nominal Typing

> There are multiple approaches to simulate Nominal Typing but no official one yet.
>
>  

**1. Type assertions**



**2. Private properties**

```tsx
class USD {
  private __nominal: void;
  constructor(public value: number) {};
}
class EUR {
  private __nominal: void;
  constructor(public value: number) {};
}
```

**3. Brands**

- introduce a unused property with `_` prefix and `Brand` suffix in name
- the *TypeScript* compiler team follows this convention. Serve to give a small amount of nominal typing
- `brands` are never actually given values. At runtime they have zero cost.
- use type assertion when needing to new up or cast down

```tsx
interface USD {
  _usdBrand: void;
  value: number;
}
interface EUR {
  _eurBrand: void;
  value: number;
}
```



#### Excess Property Checks

- **Pitfall:** properties are only checked for if they are inlined: probably a bug if an unused variable is defined inline.

**Example**

```tsx
interface Dog {
  breed: string
} 
function handleDog(dog: Dog)

```

**ok**

```tsx
const ginger = {
    breed: "Airedale",
    age: 3
}
handleDog(ginger)
```

**not ok** (inline)

```tsx
handleDog({
    breed: "Airedale",
    age: 3
})
// Argument of type '{ breed: string; age: number; }' is not assignable to parameter of type 'Dog'.
```





## Project Setup





## Basic Type Definition

#### Array

```tsx
let list: number[] = [1, 2, 3];
let list: Array<number> = [1, 2, 3];
```

#### Tuple

```tsx
let x: [string, number] = ["hello", 10];
```

#### Enum

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

**String-type Enums**

```tsx
enum Color {
  blue = "BLUE",
  green = "GREEN"
}
```

Convert value-type to enum:

```tsx
Color["GREEN"]
```

enum to union types:

```tsx
// type ValuesUnion = "BLUE" | "GREEN"
type ValuesUnion = `${StringEnum}`;

// type KeysUnion = "blue" | "green"
type KeysUnion = keyof typeof StringEnum;
```





#### Maps

- `Record<Keys, Type>`
- constructs an object type whose property keys are `Keys` and property values are `Type`

```js
const shorterMap: Record<string, string> = {
    foo: "1",
    bar: "2"
}
```



#### Nested Types

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



#### Special Types

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



#### Utility Types

- see https://www.typescriptlang.org/docs/handbook/utility-types.html





## Templated Types







## Annotating Types

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





## Union and Intersection



### Union Types

- **or**
- only properties of **both** types can be accessed

```tsx
function addPadding(padding: string | number);
```







### Intersection Types

- **and**

```tsx
interface Colorful {
  color: string;
}
interface Circle {
  radius: number;
}
 
type ColorfulCircle = Colorful & Circle;
```









## Mixins

https://www.typescriptlang.org/docs/handbook/mixins.html





## Class Utilities



#### Access Modifies

> Access modifiers can be replicated in ES6 using closures. TSX allows to introduce modifiers in a more common way.

**public/protected/private**

```tsx
class Foo {
 private x: number;
 protected y: number;
 public z: number;
}
```

**readonly**

> must be initialized at their declaration or in the constructor (similar to `const` in C++).

```tsx
class Foo {
	readonly country: string = "India";
	readonly name: string;

    constructor(_name: string) {
        this.name = _name;
    }
}
```



#### Accessors

> TypeScript supports get/set accessors to access and to set the value to a member of an object, like e.g. in C#.

- `get`/`set` declares accessors
- allows to read/write property with additional logic but usual syntax

```tsx
class Employee {
 private _fullName: string;
    
 get fullName(): string;
 set fullName(newName: string);
}

let employee = new Employee()
employee.fullName = "Hans"
```





## Open Questions



- difference between `type` and `interface`?
  - does `interface` has to be implemented explicitly?
- difference between `interface` and `class`?
  - `interface` allows to reduce dependencies but creates code duplication
  - how can you avoid this code duplication? (No re-definition of properties)
- how to annotate optional returns? i.e. `string | null`
- how to mark in/out (reference) parameters/arguments in a function? E.g. a MobX store
