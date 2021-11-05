# Bit Hacks

- sources:
  - https://graphics.stanford.edu/~seander/bithacks.html#DetectOppositeSigns
  - https://catonmat.net/low-level-bit-hacks



## Bit representation









## Bit Shifting









## Sign Comparison



**Two numbers have opposite sign**

```c++
(x ^ y) < 0
```





## Bit Extraction



**Most significant bit**

- find bit furthest to the left



**Least significant bit**

> find rightmost set bit

```cpp
n&~(n-1)
```

- 



**Is power of 2**









## Hex representation









## Backlog





### Bit Manipulation Hacks

**Number is odd**

```python
is_odd = x & 1
```

**Manipulate Nth bit**

```python
nth_is_set = x & (1<<n)
set_nth = = x | (1<<n)
unset_nth = x & ~(1<<n)
toggle_nth = x ^ (1<<n)
```

**Turn-off right-most bit**

```python
y = x & (x-1)
```





