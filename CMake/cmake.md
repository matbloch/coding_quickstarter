# CMake

- Build system to generate various `make` commands
- Written in `CMakeLists.txt` file
- `<packageName>.cmake` for CMake package configuration




## Project Structure

**Multilevel Project**
```cmake
project1
    include
    src
    CmakeLists.txt
proejct2
    include
    src
    CmakeLists.txt
....
include
CMakeLists.txt
```

## CMake Packages

###Package Setup
Consider a project "Foo" that installs the following files:

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

###Using external Packages

**`find_package(Foo)`**

- Given the name "Foo", it looks for a file called "FooConfig.cmake" or "foo-config.cmake" in the directories listed in `CMAKE_MODULE_PATH` (standard e.g.: /usr/share/cmake-2.8/modules, cmake comes with standard .cmake search files)
- `set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} ${CMAKE_SOURCE_DIR}/cmake)` to add project based /cmake folder
- `<package>_FOUND` indicates whether package was found

```cpp
CMakeLists.txt
	+ cmake
        FindFoo.cmake
        FindBoo.cmake
```



## Main Commands

cmake_minimum_required (VERSION 2.6)
project (Tutorial)

```cmake
project (Tutorial)
```


```cmake
cmake_minimum_required (VERSION 2.6)
```
**Variables**
```cmake
# define variable
set {MY_VAR "hello"}
# use variable: $ and curly brackets
set (OTHER_VAR "${MY_VAR} world!")
```

**Globals**

```cmake
# This is the source directory of the most recent project() command (dirpath to CMakeLists.txt).
${PROJECT_SOURCE_DIR}
```

**Specify Header Files**
```cmake
include_directories( ${MY_SOURCE_DIR}/src )
```

**.cmake files to find custom/user-built modules (optional)**
```cmake
set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} ${CMAKE_SOURCE_DIR}/cmake)
```

`Find<package>.cmake`

<prefix>/include/foo-1.2/foo.h
<prefix>/lib/foo-1.2/libfoo.a

<prefix>/lib/foo-1.2/foo-config.cmake

**Preprocessor Directives (adding compiler commands)**
```cmake
add_definitions(-DUSE_ARTOOLKIT)
```
Then in C++:
```cpp
#ifdef USE_ARTOOLKIT
#endif
```

# Add Source files
add_executable(Tutorial tutorial.cxx)

# Add Library

include_directories ("${PROJECT_SOURCE_DIR}/MathFunctions")
add_subdirectory (MathFunctions)

# add the executable
add_executable (Tutorial tutorial.cxx)
target_link_libraries (Tutorial MathFunctions)





## Examples

**Project Structure**

```cmake

project_name
	+ cmake
	+ src
		+ module1
		+ module2
		CMakeLists.txt
        test_feature1.cc
	+ external
		+ eigen3
		CMakeLists.txt
	CMakeLists.txt
    README.md
```

**CMakeLists.txt in `/`**

```cmake
cmake_minimum_required(VERSION 2.8 FATAL_ERROR)

# Ensure that nobody builds in the source tree
if (${CMAKE_CURRENT_SOURCE_DIR} STREQUAL ${CMAKE_CURRENT_BINARY_DIR})
  message(FATAL_ERROR "Please do not use the root directory as CMake output directory!mkdir build; cd build; cmake .. And you will have to clean the source directory by deleting CMakeCache.txt and the folder CMakeFiles")
endif ()

# Release as default
if (NOT CMAKE_BUILD_TYPE)
    message(STATUS "No build type selected, default to Release")
    set(CMAKE_BUILD_TYPE "Release")
endif()

project (myProjectName C CXX)

# add project based .cmake path to find packages
set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} ${CMAKE_SOURCE_DIR}/cmake)

# Add additional external libraries (installed on system)
find_package (OpenCV 2.4 REQUIRED)
find_package (Threads REQUIRED)

IF(NOT WIN32)
# Add external source libraries
add_subdirectory (external)
ENDIF()

# Set output folders
SET(CMAKE_RUNTIME_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/bin)
SET(CMAKE_LIBRARY_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)
SET(CMAKE_ARCHIVE_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)

# Create "${CMAKE_BINARY_DIR}/bin"
FILE(MAKE_DIRECTORY "${CMAKE_BINARY_DIR}/bin")
FILE(MAKE_DIRECTORY "${CMAKE_BINARY_DIR}/lib")

# Add the actual source files
add_subdirectory (src)
```


**CMakeLists.txt in `/src/`**
```cmake
# add to include search path
INCLUDE_DIRECTORIES(
  .
  module1
  module2
)

# conditional external package includes
IF(ARTK5_FOUND)
    INCLUDE_DIRECTORIES(
      ${ARTK5_INCLUDE_DIR}
    )
ENDIF(ARTK5_FOUND)

# ----------------- Group sources
SET(MODULE1_SRC
   module1/class1.h
   module1/class1.cc
)
SET(MODULE2_SRC
  module2/definitions2.h
)
# ----------------- Set common link libraries
SET(COMMON_LIBS ${OpenCV_LIBS})
IF(ARTK5_FOUND)
  SET(COMMON_LIBS ${COMMON_LIBS} ${ARTK5_LIBRARY})
ENDIF(ARTK5_FOUND)
# ----------------- Create libraries
# Create library (in order to compile files once)
ADD_LIBRARY(myProjectLib
  ${MODULE1_SRC}
  ${MODULE2_SRC}
)

# test feature1
ADD_EXECUTABLE(feature1 test_feature1.cc)
TARGET_LINK_LIBRARIES(px_sfm_mapper
  sfm
  ${COMMON_LIBS}
)

########################################################
# Include subfolders (process with cmake)
add_subdirectory(module1)
add_subdirectory(module2)
```

**CMakeLists.txt in `/src/module1/`**
```cmake
cmake_minimum_required(VERSION 2.8.0)
project(module1)

set (CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -g -Wall -Werror -Wno-unused-local-typedefs -std=c++11")

# add executables
add_executable(module1 ${MODULE1_SRC})
target_link_libraries(module1
  myProjectLib	# user defined library
  ${COMMON_LIBS}
)
```