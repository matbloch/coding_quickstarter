# Testing With Mocha





## Test Structure

- `describe` group similar tests
- `it` contains test code

```tsx
describe([String with Test Group Name], function() {
    it([String with Test Name], function() {
        [Test Code]
    });
});
```

```tsx
...
describe("integration test", function() {
    it("should be able to add and complete TODOs", function() {
    });
});
```



## Assertions

- see `assert` module of NodeJS: https://nodejs.org/api/assert.html



```tsx
const assert = require('assert');

assert(true);
assert.equal(a, b);
assert.deepEqual(a, b);
```



## Expect

- The module `chai` allows more checks like `expect` statements



**Example**

```tsx
describe("This", () => {
    describe("should", () => {
        it("always pass", () => {
            expect(true).to.equal(true);
        });
    });
});
```







### Examples



**Type equality**

```js
expect(options.particles.color).to.be.an("object")
```

**Array Equality**

```js
expect(members).to.have.members(['expected_title_1','expected_title_2']);
```

