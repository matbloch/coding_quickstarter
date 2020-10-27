# State Management with MobX





## Observable State

> Data that drives application

- needs to be annotated with `@observable`
- supports objects, arrays, classes, references



### A. `observable` Annotation

- `observable(source, overrides?, options?)`

**Example**

```javascript
import { observable } from "mobx"
class Todo {
    id = Math.random()
    @observable title = ""
    @observable finished = false
}
```

#### 

### B. makeObservable

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



### C. makeAutoObservable

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
        makeAutoObservable(this)
    }
    reduceEnergy() {this.energyLevel -= 10}
    get isHungry() {return this.energyLevel < 50}
}
```



## Actions

> Actions update the state. Actions run inside *transactions* - no observers are updated until outer-most action has finished.

- MobX requires declaration of actions
- `makeAutoObservable` can automate annotation
- only methods that **modify** the state should be marked as actions, **not** methods that perform filtering/calculations on the state



### Wrapping functions using `action`

- `action` is annotation **and** function

**Example**

```javascript
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







## Derivatives

### 



### Computed Values

### 





