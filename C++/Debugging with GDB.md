# Debugging with GDB

- first generate debugging information when compiling the program



**Commands**

- `q` + [enter] to quit gdb

### Compiling for debugging

TODO



## Examples

### Running Gtest with GDB

**Step 1:** Loading a program

```bash
$ gdb ./MyUnitTests
```

**Step 2:** Starting the program with GDB

```bash
(gdb) start
```

**Step 3:** Continue when we hit a breakpoint

```bash
(gdb) continue
```

**Step 4:** Backtrace if program crashes

```bash
(gdb) backtrace
```

