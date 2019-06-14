# Build Systems



### Object Files and Symbols



**Display Symbols in `.a` files**

"Demangling" to display "real" function names instead of generated ones (unique names are needed since in C++ you can overload methods).

- Linux: `nm --demangle a.out`
- MacOS: `nm a.out | c++filt`



`nm a.out | c++filt  | grep " T "`

### Static and Dynamic Libraries

http://nickdesaulniers.github.io/blog/2016/11/20/static-and-dynamic-libraries/



