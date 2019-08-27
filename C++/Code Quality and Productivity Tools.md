# Code Quality and Productivity Tools

**Productivity**

- ccache

**Code Quality**

- assertions

**Code Quality**

- clang-format
- clang-sanitize
- Gcc-latest
- Cpp-check
- Valgrind
- test coverage
- static analysis


## Assertions

- Static (compile-time) asserts
- runtime asserts



## Caching

**Installation** (MacOS)

- `brew install --HEAD ccache`

```bash
# Prepend ccache into the PATH
echo 'export PATH="/usr/local/opt/ccache/libexec:$PATH"' | tee -a ~/.bashrc

# Source bashrc to test the new PATH
source ~/.bashrc && echo $PATH
```

**Configuration**

- set cache size **big enough:** `ccache -M <max size>`

## Clang-Format


**Configuration**

- `.clang-format` file in root directory

**Commands**

- `clang-format -i my_file.cpp` inplace formatting of file

- `git clang-format -f` Format currently staged files





## Valgrind
