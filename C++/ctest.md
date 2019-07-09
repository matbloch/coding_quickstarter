# CTest





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



