# Hooks





## State Hook



```javascript
import React, { useState } from 'react';
```





## Effect Hooks

- for data fetching, subscriptions etc.
- by default: executed **every** DOM change (render and update)!



```javascript
import React, { useEffect } from 'react';
...
useEffect(() => {
   document.title = `You clicked ${this.state.count} times`;
});
...
```

**Optimizing Performance**

Previous way:

```javascript
componentDidUpdate(prevProps, prevState) {
  if (prevState.count !== this.state.count) {
    document.title = `You clicked ${this.state.count} times`;
  }
}
```
Using Hooks:
```javascript
useEffect(() => {
  document.title = `You clicked ${count} times`;
}, [count]); // Only re-run the effect if count changes
```



**Cleaning up**

- return method is called upon unmounting the component

```javascript
useEffect(() => {
    ChatAPI.subscribeToFriendStatus(props.friend.id, handleStatusChange);
    return () => {
        ChatAPI.unsubscribeFromFriendStatus(props.friend.id, handleStatusChange);
    };
});
```

