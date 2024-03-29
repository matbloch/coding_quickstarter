# GoogleTest



**Running Tests**

1. `ctest` (high level) 
   - `-V` verbose
2. `./MyTestName` (detailed output)

**Filter tests**

`--gtest_filter=POSITIVE_PATTERNS[-NEGATIVE_PATTERNS]`

`--gtest_filter=ABC.*:BCD.*`



## Writing Tests



```cpp
TBD
```



## Fixtures



**Definition**

- class that inherits from `::testing::Test`

  

```cpp
class BaseTest : public ::testing::Test {
 protected:
 		int test_variable_ = 3;
};
```

**Access**

- `TEST_F` test makro

```cpp
TEST_F(BaseTest, test_something) {
  # fixture allows easy setup of test-level resources
  ASSERT_LE(test_variable_, 4);
}
```



### Setup / Teardown Routines



**Per Test**

- For each `TEST_F`, googletest will create a **fresh** test fixture object, immediately call `SetUp()`, run the test body, call `TearDown()`, and then delete the test fixture object.

```cpp
class FooTest : public BaseTest {
 protected:
  void SetUp() override {
    ... additional set-up work ...
  }
  void TearDown() override {
    ... clean-up work for FooTest ...
  }
};
```

**Per Test Suite**

```cpp
class FooTest : public ::testing::Test {
 protected:
  // Per-test-suite set-up.
  // Called before the first test in this test suite.
  // Can be omitted if not needed.
  static void SetUpTestCase() {
    shared_resource_ = new ...;
  }

  // Per-test-suite tear-down.
  // Called after the last test in this test suite.
  // Can be omitted if not needed.
  static void TearDownTestCase() {
    delete shared_resource_;
    shared_resource_ = NULL;
  }

  // You can define per-test set-up logic as usual.
  virtual void SetUp() { ... }

  // You can define per-test tear-down logic as usual.
  virtual void TearDown() { ... }

  // Some expensive resource shared by all tests.
  static T* shared_resource_;
};

T* FooTest::shared_resource_ = NULL;

TEST_F(FooTest, Test1) {
  ... you can refer to shared_resource_ here ...
}

TEST_F(FooTest, Test2) {
  ... you can refer to shared_resource_ here ...
}
```





## Test Parametrization





**Testing for all value permutation**

```cpp
// Define the test parameter set
INSTANTIATE_TEST_SUITE_P(MyTestParams, MyTest, testing::Combine(testing::Values(1, 2, 3), testing::Values(4, 5, 6)));

// Define the test case(s)
TEST_P(MyTest, MyTestCase) {
    // Retrieve parameters
    auto params = GetParam();
    int param1 = std::get<0>(params);
    int param2 = std::get<1>(params);

    // Your test logic using param1 and param2
    // For example:
    EXPECT_GT(param1, param2);
}
```







## Mocking



### Protected Access

**Exposing `protected` members**

```cpp
class MyClass {
  protected:
  int foo(float input);
}

class Mock : public MyClass {
  public:
  using MyClass::foo;
}
```



**Inheriting constructors**

> A constructor so declared has the same access as the corresponding constructor in X.

- `using` will result in inheriting a constructor with same access level



**Example**: Exposing the protected constructor

```cpp
class Foo {
  protected:
   Foo(int i) {}
   void run() {}
};
class TestableFoo : public Foo {
  public :
    TestableFoo(int i) : Foo(i) { }
    using Foo::run;
};
```



### Mocking



**Dependency Injection through factory**

```cpp
class ISubModule {
  public:
  bool doSomething() = 0;
}
class Testable {
  public:
  	Testable(std::function<std::shared_ptr<ISubModule>> createSubModule):
	  sub_module_(createSubModule()) {}
  protected:
  	std::shared_ptr<ISubModule> sub_module_;
}
```

