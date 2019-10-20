# MobX



- tutorial: https://mobx.js.org/README.html



### Observable State

- annotation with `@observable`
- supports objects, arrays, classes



```javascrip
import { observable } from "mobx"

class Todo {
    id = Math.random()
    @observable title = ""
    @observable finished = false
}
```



### Computed Values

### 





