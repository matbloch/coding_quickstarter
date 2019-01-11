# Relay



## Setup

NPM requirements:

- react
- react-dom
- react-relay
- babel-plugin-relay (dev)
- graphql (dev)
- relay-compiler (dev)

**Configuration**

- add `relay` to babel plugins (before other plugins)
- setting up the schema compiler [see docs](https://facebook.github.io/relay/docs/en/installation-and-setup.html)



**Generating Schemas Server-Side**

- use `graphql.utils.schema_printer`

```
import json
from schema import schema
import sys
from graphql.utils import schema_printer

my_schema_str = schema_printer.print_schema(schema)
fp = open("schema.graphql", "w")
fp.write(my_schema_str)
fp.close()
```



## Writing GraphQL Queries in Relay

- use `graphql` from `react-relay`
- Allows to write GraphQL queries, usable by `QueryRenderer` and other Structures

```javascript
import {graphql} from 'react-relay';

graphql`
  query MyQuery {
    viewer {
      id
    }
  }
`;
```







## Environment

- configuration, cache storage, network-handling



```javascript
import {
  Environment,
  Network,
  RecordSource,
  Store,
} from 'relay-runtime';


function fetchQuery(
  operation,
  variables,
) {
  return fetch('/graphql', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      query: operation.text,
      variables,
    }),
  }).then(response => {
    return response.json();
  });
}

const source = new RecordSource();
const store = new Store(source);
const network = Network.create(fetchQuery);
const handlerProvider = null;

const environment = new Environment({
  handlerProvider, // Can omit.
  network,
  store,
});

export default environment;
```



### Caching







## Query Rendering

- `QueryRenderer`:  Directly render Query as a React component

- `environment` and graphql query as input



```javascript
import {graphql, QueryRenderer} from 'react-relay';

const environment = /* defined or imported above... */;

export default class App extends React.Component {
  render() {
return (
      <QueryRenderer
        environment={environment}
        query={graphql`
          query UserQuery {
            viewer {
              id
            }  
          }
        `}
        variables={{}}
        render={({error, props}) => {
          if (error) {
            return <div>Error!</div>;
          }
          if (!props) {
            return <div>Loading...</div>;
          }
          return <div>User ID: {props.viewer.id}</div>;
        }}
      />
    );
  }
}

```



**Using Query Variables**

- use `this.props` to directly synch query

The query:

```
query UserQuery($userID: ID!) {
    node(id: $userID) {
        id
    }  
}
```

Passing variables to `QueryRenderer`:

```
<QueryRenderer
  environment={environment}
  query={query}
  variables={{user_id}}
  >
```

### Fragments

- Allows to query same set of fields as part of a different query





