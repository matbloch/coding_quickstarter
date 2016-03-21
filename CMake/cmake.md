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

**1. `find_package()`**

`find_package(Foo)`

- Given the name "Foo", it looks for a file called "FooConfig.cmake" or "foo-config.cmake" in the directories listed in `CMAKE_MODULE_PATH`

**2. `find<packageName>.cmake`**

###Examples

####`find_package`: Module Mode

`Find<package>.cmake` file located within your project

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

**.cmake files to find custom/user-built modules**
```cmake
set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} ${CMAKE_SOURCE_DIR}/cmake)
```

`Find<package>.cmake`

<prefix>/include/foo-1.2/foo.h
<prefix>/lib/foo-1.2/libfoo.a

<prefix>/lib/foo-1.2/foo-config.cmake

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
	+ external
		+ eigen3
		CMakeLists.txt
	CMakeLists.txt
    README.md
```

**CMakeLists.txt in /**
```cmake
cmake_minimum_required(VERSION 2.8)

# Ensure that nobody builds in the source tree
if (${CMAKE_CURRENT_SOURCE_DIR} STREQUAL ${CMAKE_CURRENT_BINARY_DIR})
  message(FATAL_ERROR "Please do not use the root directory as CMake output directory! mkdir build; cd build; cmake .. And you will have to clean the source directory by deleting CMakeCache.txt and the folder CMakeFiles")
endif ()

# Release as default
if (NOT CMAKE_BUILD_TYPE)
    message(STATUS "No build type selected, default to Release")
    set(CMAKE_BUILD_TYPE "Release")
endif()

########################################################
##		PATH SETUP
########################################################

# .cmake files to find modules
set(CMAKE_MODULE_PATH ${CMAKE_MODULE_PATH} ${CMAKE_SOURCE_DIR}/cmake)

# The version number.
set (SFM_VERSION_MAJOR 0)
set (SFM_VERSION_MINOR 1)

# Set output folders
SET(CMAKE_RUNTIME_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/bin)
SET(CMAKE_LIBRARY_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)
SET(CMAKE_ARCHIVE_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)

# Create "${CMAKE_BINARY_DIR}/bin"
# ToDo: check why this is needed!
FILE(MAKE_DIRECTORY "${CMAKE_BINARY_DIR}/bin")
FILE(MAKE_DIRECTORY "${CMAKE_BINARY_DIR}/lib")

########################################################
##		EXTERNAL LIBRARIES INSTALLED ON SYSTEM
########################################################

find_package (OpenCV 2.4 REQUIRED)
find_package (Protobuf REQUIRED)
find_package (OpenGL REQUIRED)
find_package (GLEW REQUIRED)
find_package (Threads REQUIRED)

########################################################
##		ADD SOURCES
########################################################

# Add external source libraries
add_subdirectory (external)

# Add the actual source files
add_subdirectory (src)

```

**CMakeLists.txt in /src/**

```cmake
# Add all includes
INCLUDE_DIRECTORIES(
  .
  module1
  module2
  ../external/eigen3
)

# save library source files into variable
SET(FEATURES_SRC
   features/fast.h
   features/fast.cc
   features/lehf.h
   features/lehf.cc
   features/lsd.h
   features/lsd.cc
   features/LSWMS.h
   features/LSWMS.cpp
   features/matching.h
   features/matching.cc
)

# Create library (named ${PROJECT_NAME}) to use with "TARGET_LINK_LIBRARIES"
ADD_LIBRARY(${PROJECT_NAME}
  ${DISPLAY_SRC}	# define files in variable
  ${FEATURES_SRC}	# define files in variable
  ${GEOMETRY_SRC}	# define files in variable
)

# Add output executables (name file.extension)
ADD_EXECUTABLE(test_dense test_dense.cc)

TARGET_LINK_LIBRARIES(test_dense 	# name
  ${PROJECT_NAME} 					# custom library
  glut								# additional library
  GL GLEW							# additional library
)

```



