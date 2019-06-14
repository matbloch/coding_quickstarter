# Javascript



## Do's/Don'ts

- case sensitive: Upper/lowercase


# ECMA Script 6



#### Destructuring

**Arrays**
```javascript
var a, b, rest;
[a, b] = [10, 20];
[a, b, ...rest] = [10, 20, 30, 40, 50];
```

**Objects**

```javascript
var o = {p: 42, q: true};
// basic assignent
var {p, q} = o;
// assignment without declaration
var a, b;
({a, b} = {a: 1, b: 2});
let {a, b, ...rest} = {a: 10, b: 20, c: 30, d: 40}
```


**From Function Arguments**

```javascript

var user = {
  id: 42,
  displayName: 'jdoe',
  fullName: {
      firstName: 'John',
      lastName: 'Doe'
  }
};
function userId({id}) {
  return id;
}

function whois({displayName, fullName: {firstName: name}}) {
  console.log(displayName + ' is ' + name);
}

```

