# Tipps



see https://abseil.io/tips/107





```cpp
A a;
B(a);
B.a;
class B {
  public:
  B(A const & a): a(a){}
  A const & a;
}
```









## C++11 Brace Initialization