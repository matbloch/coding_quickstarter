# React Router





### Examples





```jsx
export default function App() {
  return (
    <Router>
        <nav>
      		<Link to="/">Home</Link>
            <Link to="/about">About</Link>
            <Link to="/users">Users</Link>
        </nav>
        {/* A <Switch> looks through its children <Route>s and
            renders the first one that matches the current URL. */}
        <Switch>
          <Route path="/about"><About /></Route>
          <Route path="/"><Home /></Route>
        </Switch>
    </Router>
      )
```

