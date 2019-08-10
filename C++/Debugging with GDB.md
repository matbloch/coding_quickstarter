# Debugging with GDB

- first generate debugging information when compiling the program







### Compiling for debugging

TODO

### Commands

- `q` + [enter] to quit gdb
- `p <variable_name>` print a local variable



## Examples

### Running Gtest with GDB

**Step 1:** Loading a program

```bash
$ gdb ./MyUnitTests
```

**Step 2:** Starting the program with GDB

```bash
(gdb) run
```

```bash
(gdb) run --gtest_filter=MyUnitTests.specific_test
```

**Step 3:** Continue when we hit a breakpoint

```bash
(gdb) continue
```

**Step 4:** Backtrace if program crashes

```bash
(gdb) backtrace
```

```
(gdb) backtrace
#0  0x0000000000439ced in std::char_traits<char>::length (__s=0x0)
    at /opt/OSELAS.Toolchain-2016.06.1/x86_64-unknown-linux-gnu/gcc-5.4.0-glibc-2.23-binutils-2.26-kernel-4.6-sanitized/x86_64-unknown-linux-gnu/include/c++/5.4.0/bits/char_traits.h:267
#1  0x00000000004650f2 in std::__cxx11::basic_string<char, std::char_traits<char>, std::allocator<char> >::compare (this=0x2321370, __s=0x0)
    at /opt/OSELAS.Toolchain-2016.06.1/x86_64-unknown-linux-gnu/gcc-5.4.0-glibc-2.23-binutils-2.26-kernel-4.6-sanitized/x86_64-unknown-linux-gnu/include/c++/5.4.0/bits/basic_string.tcc:1398
#2  0x0000000000464c4c in std::operator==<char, std::char_traits<char>, std::allocator<char> > (__lhs=..., __rhs=0x0)
    at /opt/OSELAS.Toolchain-2016.06.1/x86_64-unknown-linux-gnu/gcc-5.4.0-glibc-2.23-binutils-2.26-kernel-4.6-sanitized/x86_64-unknown-linux-gnu/include/c++/5.4.0/bits/basic_string.h:4939
#3  0x0000000000464698 in testing::internal::CmpHelperEQ<std::__cxx11::basic_string<char, std::char_traits<char>, std::allocator<char> >, char const*> (lhs_expression=0x1474765 "expected_cats[i]",
    rhs_expression=0x147475d "cats[i]", lhs=..., rhs=@0x2264c10: 0x0)
```

**Step 5:** Select frame

```bash
(gdb) f3
```

**Step 6:** Print variables

```bash
(gdb) p i
```

```bash
(gdb) p cats[i]
```



