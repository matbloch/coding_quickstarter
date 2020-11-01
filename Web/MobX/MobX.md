# State Management with MobX

<Benefits of using MobX>





## Core Concepts

**Observable**

- when the data changes, the observable object notifies the observers
- `@observable`

```js
class TodoStore {
  @observable todos: Todo[]
}
```

**Actions**

- way to change observable (update the state)
- `@action`

```js
@action toggleTodo = (todo: string) => {
    this.todos.push_back(todo);
};
```

**Computed**

- derive values from existing state / other computed values
- `@computed`

```js
@computed get isEmpty() {
    this.todos.len == 0;
}
```

**Reactions**

- track observables from inside the store itself
- trigger side effects

```js
class TodoStore {
  constructor() {
    reaction(
      () => this.todos,
      _ => console.log(this.todos.length)
    );
}
```





## Observable State

> Data that drives application

- needs to be annotated with `@observable`
- supports objects, arrays, classes, references

**Making State Observable**

- `@observable` annotation 
  - on individual properties
- `makeObservable` 
  - specify type of all methods in constructor
- `makeAutoObservable`
  - derive type of all methods during construction automatically
- direct use of MobX observable datastructures
  - `observable.array`, `observable.map`, ...
  - `@observable` and `makeObservable` create a copy and then mount the data in containers



### Make State Observable

#### A. `@observable` Annotation

- `observable(source, overrides?, options?)`

**Example:** Decorator

```javascript
import { observable } from "mobx"
class Todo {
    id = Math.random()
    @observable title = ""
    @observable finished = false
}
```

**Example:** Method/function

```javascript
const peopleStore = observable([
  { name: "Michel" },
  { name: "Me" }
]);
```

#### B. `makeObservable`

- make **existing** object properties observable
- typically used in constructor of class

**Usage**

`makeObservable(target, annotations?, options?)`

- `annotations` argument maps annotations to each member
- (Deprecated in MobX V6): `annotations` can be omitted if decorators are used (e.g. `@observable`, `@action`, ...)

**Example:**

```javascript
import { makeObservable, observable, computed, action } from "mobx"

class Doubler {
    value
    constructor(value) {
        makeObservable(this, {
            value: observable,
            double: computed,
            increment: action
        })
        this.value = value
    }
    get double() { return this.value * 2}
    increment() { this.value++ }
}
```

#### C. `makeAutoObservable`

- like `makeObservable` but infers all properties
- `false` can be used to exclude property/method
- cannot be used with super/sub-classes

**Example**

```javascript
class Animal {
    name
    energyLevel

    constructor(name) {
        this.name = name
        this.energyLevel = 100
        makeAutoObservable(
            this, {
                name: false // exclude property name
            }
        )
    }
    reduceEnergy() {this.energyLevel -= 10}
    get isHungry() {return this.energyLevel < 50}
}
```

### State References

- references between stores are automatically handled

**Example**

```javascript
const peopleStore = observable([
  { name: "Michel" },
  { name: "Me" }
]);
observableTodoStore.todos[0].assignee = peopleStore[0];
observableTodoStore.todos[1].assignee = peopleStore[1];

// also updates observableTodoStore
peopleStore[0].name = "Michel Weststrate";
```



### Custom Observable Stores









## Actions

> Actions update the state. Actions run inside *transactions* - no observers are updated until outer-most action has finished.

- MobX requires declaration of actions
- `makeAutoObservable` can automate annotation
- only methods that **modify** the state should be marked as actions, **not** methods that perform filtering/calculations on the state

### @action annotation

```js
@action setPredicate(store) {
    store.some_property = 123;
}
```

### Wrapping functions using `action`

- `action` is annotation **and** function

**Example**: click handler

```javascript
import { action } from "mobx"
const ResetButton = ({ formState }) => (
    <button
        onClick={action(e => {
            formState.resetValues()
            e.stopPropagation()
        })}
    >
        Reset form
    </button>
)
```

**Example: **Async Action

```javascript
setTimeout(action(() => {
  observableTodoStore.addTodo('Random Todo ' + Math.random());
}), 2000);
```





### Asynchronous Actions

- no special treatment - updates work automatically
- handlers that update state should be `actions`

**Example:** Wrap handlers in `action`



```javascript
import { action, makeAutoObservable } from "mobx"

class Store {
    githubProjects = []
    state = "pending" // "pending", "done" or "error"

    constructor() {
        makeAutoObservable(this)
    }

    fetchProjects() {
        this.githubProjects = []
        this.state = "pending"
        fetchGithubProjectsSomehow().then(
            action("fetchSuccess", projects => {
                const filteredProjects = somePreprocessing(projects)
                this.githubProjects = filteredProjects
                this.state = "done"
            }),
            action("fetchError", error => {
                this.state = "error"
            })
        )
    }
}
```



## Derivatives / Computed Properties

> Computed values can be used to derive information from other observables.

- evaluated lazily, have output caching

- declaration:
  - use `makeObservable` to declare getter as computed
  - (Deprecated) decorators

**Example:** Decorator

```javascript
import { observable, computed } from "mobx"

class OrderLine {
    @observable price = 0
    @observable amount = 
    constructor(price) {
        this.price = price
    }
    @computed get total() {
        return this.price * this.amount
    }
}
```







## MobX and React

