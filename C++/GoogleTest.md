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





## Mocking



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



