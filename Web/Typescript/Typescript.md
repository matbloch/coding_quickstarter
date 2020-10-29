# Typescript

- based on "duck typing"





**Features**

- hard typing
- type inference
- interfaces
- type aliasing
- additional types: any, void, enums, tuple, ...





## Type Annotation

- use **lowercase** basic type names
- 



**Variables**

```javascript
let my_var: string = "abc";
```

**Methods**

```javascript
function getUser(name: <ArgumentType>): <ReturnType> {}
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



## Basic Types

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

**Never**

- return type of function that have no reachable end





### Type Assertions / Casting

```tsx
let strLength: number = (someValue as string).length;
let strLength: number = (<string>someValue).length;
```







## Interfaces

- duck-typed



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
- readonly flagged with `readonly`

```tsx
interface SquareConfig {
        name: string;
      color?: string;
      width?: number;
  readonly x: number;
}
```

### Array Interfaces

**Readonly Array**

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







