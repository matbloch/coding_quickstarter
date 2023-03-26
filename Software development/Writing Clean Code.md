# Best Practices

**Good reads**

- clean code





## Polymorphism in C++



1. Virtual functions (runtime)
   - dynamic binding: Function resolved at runtime through v-tables (size overhead for v-table pointer and speed overhead for indirection)
2. Function overloading (compile-time)
   - can lead to confusion if arguments are similar
   - cannot implement polymorphism across class hierarchies
3. Templates (compile-time)
   - can lead to code bloat and is difficult to udnerstand





## Inheritance vs Composition

> Composition is for code reuse, inheritance is for flexibility (dynamic binding)

**Composition**

- positive
  - flexibility
  - better encapsulation through separation of concerns and dependencies
  - facilitates code reuse
  - implementation hidden (header files not exposed)
- negative
  - may require more  (and more complex) code. Relationship must be defined.
  - can introduce overhead since objects are allocated/destroyed at runtime
  - classes can be switched at runtime

**Inheritance**

- positive
  - code reuse
- negative
  - coupling
  - requires hierarchic structure
  - code bloat: derived class introduce unnecessary props/methods from base class
  - multiple inheritance: see below

**Multiple Inheritance**

- negative
  - **Diamond problem:** ambiguous behavior if multiple identical functions. Needs explicit resolution (virtual inheritance).
  - **Complexity**: Leads to complex class hierarchies. Difficult to understand what implementation is used.
  - **Name collision**: method and attribute names can collide between class and parent
  - **Coupling:** coupling between classes, makes it hard to modify one individually

