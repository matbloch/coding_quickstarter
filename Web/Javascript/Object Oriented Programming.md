# Object Oriented Programming



## Class Definition

- only arrow functions have access to `this` (function binding)
- properties in class scope are per instance

```javascript
class Number {
  name = "John";
  constructor(value) {
    this.value = value;
  }
  click = () => {
    alert(this.value);
  }
  method1() { ... }
  method2() { ... }
}
```

**Instantiation**

```javascript
mycar = new Car("Ford");
```

**Static Members**

- `static` keyword

```javascript
...
  static add = (x, y) => {
    return x + y;
  }
  // only in latest chrome
  static publisher = "Ilya Kantor";
...
```

**Getters / Setters**

- `get` / `set`  keywords
- no parenthesis needed

```javascript
class Car {
  constructor(name) {this.carname = name;}
  get name() {return this.carname;}
  set name(x) {this.carname = x;}
}
```

```javascript
my_car_instance.name = name 
```





## Scoping

**Protected**

- `_` prefix
- Not enforced

```js
class CoffeeMachine {
  _waterAmount = 0;
}
```

**Private**

- `#` prefix
- enforced by language

```js
class CoffeeMachine {
  #waterLimit = 200;
}
```



## Inheritance

https://javascript.info/class-inheritance

- `extends` keyword
- Constructors in inheriting classes must call `super(...)` **before** using `this`
- `super` to access parent class
  - arrow functions have no `super`!

```javascript
class Model extends Car {
  constructor(brand, mod) {
    // instantiating base class
    super(brand);
    this.model = mod;
  }
  // calling the base class
  call_baseclass_method() {
    return this.method_of_base_class();
  }
}
```

**Overrides**

- use same method name



### Extending Built-in Classes

```js
class PowerArray extends Array {
  isEmpty() {
    return this.length === 0;
  }
}
```



## Mixins

- use `Object.assign` to 

```js
// mixin
let sayHiMixin = {
  sayHi() {
    alert(`Hello ${this.name}`);
  },
  sayBye() {
    alert(`Bye ${this.name}`);
  }
};

class User {...}
// copy the methods
Object.assign(User.prototype, sayHiMixin);
```

**Mixin Inheritance**

- declare in `__proto__`

```js
let sayMixin = {};
let sayHiMixin = {
  __proto__: sayMixin,
}
```





## Prototypes

https://javascript.info/prototypes