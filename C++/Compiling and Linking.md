# Compiling and Linking







## Static and Inline Functions



- defining function implementation in header: will automatically be inlined







## Linker Problems







#### Function Definition in .h file

- Error: `duplicate symbol`

**Solution**

- Implementation in source file
- make function `inline`



https://stackoverflow.com/questions/47945654/duplicate-symbol-of-a-function-defined-in-a-header-file