# Store Design

- Class instances will never be made observable automatically by passing them to `observable`





## What is observed?

**Observing Class Instances**

- Classes are **not** automatically observed like plain objects
- use `makeObservable` in class constructor
- add `"useDefineForClassFields": true` to Typescript configuration

**Converting observables back to vanilla JS**

```js
const plainObject = { ...observableObject }
const plainArray = observableArray.slice()
const plainMap = new Map(observableMap)
```





## Organizing Stores / State



![cascaded-state](img/cascaded-state.png)

### Linking Stores

```ts
class Parent {
  Parent(){
    child = Child(parent: this);
  }
  Child child;
}
```







## Examples



### Nested Stores

```tsx
type FilterFlags<Base, Condition> = { [Key in keyof Base]: Base[Key] extends Condition ? never : Key };
type AllowedNames<Base, Condition> = FilterFlags<Base, Condition>[keyof Base];
type SubType<Base, Condition> = Pick<Base, AllowedNames<Base, Condition>>;
export type OnlyData<T> = SubType<T, (_: any) => any>;
```



```tsx
import { action, computed, observable, makeObservable } from 'mobx'

class Todo {
	title: string
    description?: string
    constructor(args: OnlyData<Todo>) {
        makeObservable(this, {
            title: observable,
            description: observable
        })
        Object.assign(this, args)
    }
}

export class Todos {
    todos: Todo[] = []
    
    constructor(args: OnlyData<Todo>[]) {
        makeObservable(this, {
            todos: observable.shallow
        })
        args.forEach(this.addTodo)
    }
    
    addTodo(todo: Todo) {
        this.list.push(todo)
    }
}
```









### Initialize the Global Store

TODO

```js
const MyContext = React.createContext(defaultValue);
```

```js
<MyContext.Provider value={/* some value */}>
```



**Example:** Global Store

1. **Define the store context**

```jsx
import React, { createContext } from 'react';
import { StoreModel } from '../stores';
export const StoreContext = createContext<StoreModel>({} as StoreModel);
```

2. **Define the store provider**

```jsx
import { FC, createContext, ReactNode, ReactElement } from 'react';
export const StoreProvider: StoreComponent = ({
  children,
  store
}): ReactElement => {
  return (
    <StoreContext.Provider value={store}>{children}</StoreContext.Provider>
  )
}

/* Hook to use store in any functional component */
export const useStore = () => React.useContext(StoreContext)

/* HOC to inject store to any functional or class component */
export const withStore = (Component) => (props) => {
    return <Component {...props} store={useStore()} />
}
```

3. **Wrap the application in the store provider**

```jsx
<StoreProvider store={new StoreModel()}>
    <App />
</StoreProvider>
```

4. **Access the store somewhere in the application**

For functional components

```tsx
import { useObserver } from 'mobx-react-lite'
const doSomething = withStore(({ store }) => {
  // use properties of the store
  
  // wrap the returned content in a observer in order to react to changes in observables
  return useObserver(() => (<div>{store.someProperty}</div>))
})
```



## Open Questions



- How to properly initialize nested stores from plain objects/json?
  - do we need to initialize classes with `new` inside the owning storage and just allow `DataOnly<MyClass>` inputs?
