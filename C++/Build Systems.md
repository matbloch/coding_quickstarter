# Build Systems



### Object Files and Symbols



**Display Symbols in `.a` files**

"Demangling" to display "real" function names instead of generated ones (unique names are needed since in C++ you can overload methods).

- Linux: `nm --demangle a.out`
- MacOS: `nm a.out | c++filt`

  - Checking for a symbol:`nm a.out | c++filt  | grep " T "`

### Static and Dynamic Libraries

http://nickdesaulniers.github.io/blog/2016/11/20/static-and-dynamic-libraries/





## CMake

`VERBOSE=1 make`

- [tutorial: building and linking libraries](https://github.com/ttroy50/cmake-examples/tree/master/01-basic/C-static-library)