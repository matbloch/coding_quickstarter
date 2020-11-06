# Higher-Order Components (HOC)

> A higher-order component (HOC) is a function that takes a component and returns a new component. A HOC *composes* the original component by *wrapping* it in a container component.

- allows to extend components while keeping codebase modular and separate component implementation





**Using HOC`s**

- in most cases: Apply HOCs to components at export
- `const EnhancedHOCComponent = hoc(OriginalReactComponent);`

```jsx
import { withFunctions } from 'my-module';
class OriginalComponent extends React.Component {...}
// export the wrapped component directly
export default withFunctions(OriginalComponent);
```



## Enhancers

> Wrap a component in additional functionality/props



### Definition

**Basic**

As class component

```jsx
const withLoading = Component =>
  class WithLoading extends React.Component {
    // make some enhancements
    // ...
    render() {
      const { loading, ...props } = this.props;
      return loading ? <LoadingSpinner /> : <Component {...props} />;
    }
  };
```

As 

**With types**

- `P` props of the component that is passed into the HOC
- `React.ComponentType<P>` type annotation for function or class component

```jsx
// interface for enhancing properties
interface WithLoadingProps {
  loading: boolean;
}
```

Class component `React.Component`

```jsx
// withLoading.tsx
const withLoading = <P extends object>(Component: React.ComponentType<P>) =>
  class WithLoading extends React.Component<P & WithLoadingProps> {
    render() {
      const { loading, ...props } = this.props;
      return loading ? <LoadingSpinner /> : <Component {...props as P} />;
    }
};
```

Or as functional component `React.FunctionComponent`

```jsx
const withLoading = <P extends object>(
  Component: React.ComponentType<P>
): React.FC<P & WithLoadingProps> => ({
  loading,
  ...props
}: WithLoadingProps) =>
  loading ? <LoadingSpinner /> : <Component {...props as P} />;
```



### Consumption





## Injectors

> Inject/remove props from a component



## Examples



### State Abstraction and Manipulation

- inject state
- add handler method to update the injected state

**Example:** Inject local state

```jsx
import React from 'react';

export function withFunctions(WrappedComponent) {
   return class extends React.Component {
     // introduce additional state
     constructor(props) {
         super(props);
         this.state = {
            email: ''
         };
     }
     // add a state handler
     onEmailUpdate = (event) => {
         this.setState({ email: event.target.value });
     }
     // expose it to the wrapped component
     render() {
         return 
           <WrappedComponent 
             {...this.props}
             email={this.state.email}
             onEmailUpdate={this.onEmailUpdate}
           />
      }
   }
}
```

**Example:** Inject a global state store

```jsx
export function withFunctions(WrappedComponent) {
    return class extends React.Component {
        // hook i nto a global state store
        constructor(props) {
           super(props);
           this.state = {
              email: store.get('email') || {}
           };
        }
        // expose it to the wrapped component
        render() {
            return
            <WrappedComponent
                {...this.props}
                {...this.state}
                onEmailUpdate={this.onEmailUpdate}
            />
        }
    }
}
```



## TypeScript Examples



### 