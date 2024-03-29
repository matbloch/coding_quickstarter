# Google Mock

Source: https://google.github.io/googletest/gmock_cook_book.html

See also: https://gitlab.inria.fr/Phylophile/Treerecs/blob/master/tests/gtest/googlemock/docs/CheatSheet.md



## Mocking Classes



### Definition

**Requirements for mocking**

- `virtual` methods: Non-virtual methods can only be mocked if production code is templated (more complicated)



**Example**

Original class:

```cpp
class Turtle {
  ...
  virtual ~Turtle() {}
  virtual void PenUp() = 0;
  virtual void Forward(int distance) = 0;
  virtual void GoTo(int x, int y) = 0;
  virtual int GetX() const = 0;
};
```

The mocked class:

```cpp
class MockTurtle : public Turtle {
 public:
  ...
  MOCK_METHOD(void, PenUp, (), (override));
  MOCK_METHOD(void, Forward, (int distance), (override));
  MOCK_METHOD(void, GoTo, (int x, int y), (override));
  MOCK_METHOD(int, GetX, (), (const, override));
};
```



### Usage

```cpp
#include "gmock/gmock.h"
#include "gtest/gtest.h"

using ::testing::AtLeast;                         // #1

TEST(PainterTest, CanDrawSomething) {
  // use the mocked class
  MockTurtle turtle;                              // #2
  // get access to more testing utilities on the mocked methods
  EXPECT_CALL(turtle, PenDown())                  // #3
      .Times(AtLeast(1));
}
```



## Call Assertions

- Definition:
  - 1st argument: object
  - 2nd argument: method and arguments
- All `EXPECT` are sticky by default

```cpp
EXPECT_CALL(mock_object, method(matchers))
    .Times(cardinality)
    .WillOnce(action)
    .WillRepeatedly(action);
```



**Example:**

```cpp
using ::testing::Return;
...
EXPECT_CALL(turtle, GetX())
    .Times(5)
    .WillOnce(Return(100))
    .WillOnce(Return(150))
    .WillRepeatedly(Return(200));
```



### Expected Argument

- use `_` for "anything"

- omit parameters if they don't matter

  

**Example:** Anything

```cpp
using ::testing::_;
...
// Expects that the turtle jumps to somewhere on the x=50 line.
EXPECT_CALL(turtle, GoTo(50, _));
```

**Example:** Parameters don't matter

```cpp
// Expects the turtle to move forward.
EXPECT_CALL(turtle, Forward);
// Expects the turtle to jump somewhere.
EXPECT_CALL(turtle, GoTo);
```



### Expected Actions

- call count is inferred from `.Times` or  `.WillOnce` count

**Example:** call N times

```cpp
using ::testing::Return;
...
EXPECT_CALL(turtle, GetY())
     .WillOnce(Return(100))
     .WillOnce(Return(200))
     .WillRepeatedly(Return(300));
```



### Expected Call Order









## Advanced Structure Assertions



**Checking exact elements**

```cpp
using ::testing;
```

```cpp
//checks that vector v is {5, 10, 15}
ASSERT_THAT(v, ElementsAre(5, 10, 15));

//checks that map m only have elements 1 => 10, 2 => 20
ASSERT_THAT(m, ElementsAre(Pair(1, 10), Pair(2, 20)));

//checks that in vector v all the elements are greater than 10 and less than 20
ASSERT_THAT(v, Each(AllOf(Gt(10), Lt(20))));

//checks that vector v consist of 
//   5, number greater than 10, anything.
ASSERT_THAT(v, ElementsAre(5, Gt(10), _));
```



**Checking list of structures**

- define custom matcher

```cpp
// some test type
struct Foo {
    bool b;
    int i;
};

// define a matcher if ==operator is not needed in production
MATCHER_P(EqFoo, other, "Equality matcher for type Foo") {
    return std::tie(arg.b, arg.i) == std::tie(other.b, other.i);
}

// example usage in your test
const Foo test_value {true, 42};
EXPECT_CALL(your_mock, YourMethod(EqFoo(test_value)));
```







