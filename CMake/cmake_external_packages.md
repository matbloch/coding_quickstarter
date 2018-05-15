# Using Globaly Installed Packages

### Library Types


see [Explanation](https://stackoverflow.com/questions/12237282/whats-the-difference-between-so-la-and-a-library-files)

- `.a` **static libraries**
	- `.a` for "archive". Just packed files of object (`.o`). Liked applications include a copy of the objects into the resulting executable.
- `.so`, `.dll` **dynmaic libraries**
	- `.so` for "shared object". All applications that are linked use the same file rather than copying it into the resulting executable.

**Static**


**Dynamic**



### Package Setup



###Package Setup
Consider a project "Foo" that installs the following files globally:

`<prefix>/include/foo-1.2/foo.h`
`<prefix>/lib/foo-1.2/libfoo.a`

It may also provide a CMake package configuration file

`<prefix>/lib/foo-1.2/foo-config.cmake`

with content such as:

```cmake
# ...
# (compute PREFIX relative to file location)
# ...
set(foo_INCLUDE_DIRS ${PREFIX}/include/foo-1.2)
set(foo_LIBRARY ${PREFIX}/lib/foo-1.2/libfoo.a)
```

###Including external Packages

Setup up follwing for IDE in CMake:
1. C++ inlcude directory (with header files)
2. Linker dependencies (.lib which include the functions defined in the header files)


**0. Define project dependency**
`find_package(Foo)`
- Looks for installed packages or in CMAKE_MODULE_PATH for a <package>-config.cmake file which defines `<package>_INCLUDE_DIRS` (header files) and `<package>_LIBRARY` (.lib path) (often: and also includes the header files)
- `<package>_FOUND` indicates whether package was found

**1. Setting up include path**
- If necessary: `include_directories(<package>_INCLUDE_DIRS)` (often already done in <package>-config.cmake)

**2. Define Linker path for executable**
```bash
## Main executables
ADD_EXECUTABLE(main_program main.cpp)
TARGET_LINK_LIBRARIES(main_program
  user_identification	# custom module library
  ${<package>_LIBRARY}	# 3rd party library
)
```




**Manual Package Search: `Find<package>.cmake`**
- `find_package(Foo)`: Given the name "Foo", it looks for a file called "FooConfig.cmake" or "foo-config.cmake" in the directories listed in `CMAKE_MODULE_PATH` (standard e.g.: /usr/share/cmake-2.8/modules, cmake comes with standard .cmake search files)
- `set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} ${CMAKE_SOURCE_DIR}/cmake)` to add project based /cmake folder
- If package does not provide `<package>-config.cmake`: Add environment variable to lib directory and set the include/linker path through `Find<package>.cmake` using the environment variable: `$ENV{<package>_DIR}`

```cpp
CMakeLists.txt
	+ cmake
        FindFoo.cmake
        FindBoo.cmake
```


