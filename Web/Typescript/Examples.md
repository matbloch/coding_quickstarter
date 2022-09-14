# Examples





#### Array of different types

```tsx
// [1, "abc"]
(string|number)[]
```





#### Accessing Union Properties

1. create type checker function with `is <Type>` return type

```tsx
const isTypeA = (value: TypeA | TypeB): value is TypeA => {
    return value.hasOwnProperty('itemName');
}
```

2. use it as access guard

```tsx
function getItemName(item: TypeA | TypeB): string {
    return isTypeA(item) ? item.itemName : item.itemTitle;
}
```





#### Class Initialization

```tsx
class Person {
    public name: string = "default"
    public address: string = "default"
    public age: number = 0;

    public constructor(init?:Partial<Person>) {
        Object.assign(this, init);
    }
}

let persons = [
    new Person(),
    new Person({}),
    new Person({name:"John"}),
    new Person({address:"Earth"}),    
    new Person({age:20, address:"Earth", name:"John"}),
];
```

