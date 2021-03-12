# Data Encoding and Numeral Systems



## Endianness

> Ordering of bytes when processor stores data from register into memory

- Big-endian: Start storing with **most-significant** bit
- Little-endian: Start storing with **least-significant** bit



![big-endian](D:\dev\coding_quickstarter\Fundamentals\img\big-endian.png)![little-endian](D:\dev\coding_quickstarter\Fundamentals\img\little-endian.png)

**When to care about Endianness?**

- transferring files between processors that use a different system
- send bytes over network (e.g. TCP/IP is defined to be big-endian)



## Binary



- bit: 0 or 1
- byte: 8 bits, range: [0, ... , 255]



**Negative number representation**

- left-most bit is used for `sign`: `1` means negative numbers



### Bit Operations

```
&   -  bitwise and
|   -  bitwise or
^   -  bitwise xor
~   -  bitwise not
<< -  bitwise shift left
>>  -  bitwise shift right
```





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



## Hexadecimal



| Code   | Byte value | Decimal value | Hexadecimal value |
| ------ | ---------- | ------------- | ----------------- |
| `11`   | 00001011   | 11            | B                 |
| `0x11` | 00010001   | 17            | 11                |
| `B11`  | 00000011   | 3             | 3                 |





