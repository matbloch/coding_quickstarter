

# Testing Patterns and Code Quality















## Levels of Testing



![testing-types](img/testing-types.png)





- Integration testing
- Functional / end-to-end testing
  - Used to check the functionalities of a software system i.e. output to the given input.
  - Difference to integration test: Would only check return, not that connection to db was established
- Exploratory testing
  - fuzzying




- static testing
  - Code review
  - Code inspectoin
- dynamic testing
  - unit tests
  - unit coverage
    - path coverage
    - function coverage
  - code complexity

- structural white box testing
  - control flow testing
  - basic path testing
  - data flow testing
  - loop testing





- Regression testing: Verify that the system still works as intended
- Functional testing: Test things related to functionality
- Exploratory testing:
  - E.g. input fuzzying









#### 01. Unit Testing

> Test lines of code - the module design.
>
> - Focuses on very small functional units
> - The simplest way to check smallest units for isolation
> - Generally performed by developers







#### 02. Integration Testing

> Test interfaces of interconnected units - the architecture design.





Approaches:

**Big Bang**





**Top-down**





**Bottom-up**

¨



#### 03. System Testing

> Test all the integrated modules as a collective system - the high level design
>
> - Combines multiple features into end-to-end scenarios
> - Checks both functional and non-functional requirements







#### 04. User Acceptance Testing

> Test software-requirement fit



- Alpha testing
- Beta testing
- Contract acceptance
- ...







### Other

- Performance testing
  - Performance tests check the behaviors of the system when it is under significant load. 
- Smoke testing
  - Smoke tests are basic tests that check basic functionality of the  application. They are meant to be quick to execute, and their goal is to give you the assurance that the major features of your system are  working as expected.
- Acceptance testing
  - Acceptance tests are formal tests executed to verify if a system satisfies its business requirements. (i.e. client interaction works as expected) 





## Test Approaches







### 01. Black Box vs White Box Testing



**Black Box testing**

> Tests the functionality of the software application rather than the source code. What is the output for a given input?

- tester doesn't see underlying code
- generally done on higher levels (acceptance testing/system testing) by software testers

- Methods
  - Boundary value testing



**White Box testing**

> Examine program structure and business logic

- tester sees everything

- requires programming/technical expertise

- mostly done by software engineers

- Methods

  - **Statement/Line Coverage:** Examines all the programming statements.
  - **Branch Coverage:** Series of running tests to ensure if all the branches are tested.
  - **Path:** Path coverage refers to designing test cases such that all linearly  independent paths in the program are executed at least once. A linearly  independent path can be defined in terms of what’s called a control flow graph of an application.
    - Different levels over coverages: Node, link and loop coverage (when looking at the execution graph of the program)

  



### 02. Functional vs Structural Testing



- Functional Testing (Black Box)

  > - Tests as described by external specs
  > - Functional mapping Input => Output
  > - Without involving internal knowledge

  - unit testing
  - integration testing
  - smoke testing
  - User Acceptance Testing (UAT)

- Structural Testing (White Box)

  > Tests internal implementations. White-box in nature.

- Non Functional Testing

  - Load testing
  - Performance Testing
  - Usability Testing
  - Volume Testing

- Change Related Testing

  - Re-testing / Confirmation TEsting
  - Regresssion Testing

  





##### 03.1 Functional Testing

> Deals with functional specifications or business requirements



- Unit testing
- Interface testing
- Smoke testing
- Integration testing
- Regression testing
- Sanity testing
- System testing
- Usability testing



##### 03.1 Non-Functional Testing

> Deals with performance of the application

- Performance testing

  - Load testing

  - Stress testing

  - Scalability testing

- compatibility testing

- security testing

- recovery testing









## Code Quality Tools



- Static (compile-time) asserts
- Runtime asserts
- Static code analysis
  - Code sanitizers: Spots potential issues
  - Code formatters
- Dynamic code analysis
  - zombies/memory leaks
  - invalid memory access / undef behaviour
- Code reviews
- Unit tests







## Testing Patterns



### Transactions

- Fundamental concept of all database systems
- Bundles multiple steps into a single, all-or-nothing operation

**Properties**

- **Atomic:** succeeded, or failed

- **Isolation:** ensures that transactions operated independently of of others; they are not visible till completed

  

### Fixtures

**Test Flow**

1. Begin transaction
2. Factories
3. Execute Logic
4. Assertions
5. Rollback transaction



### Mocking

TBD





### Fuzzying



