


# OpenCV 2.4

---------

## Windows

### B. Building from Source (Microsoft Visual Studio)

- Download and extract source from: https://sourceforge.net/projects/opencvlibrary/files/opencv-win/
- OpenCV 2.4.13 is ++not++ precompiled for VS14 2015! We need to compile it first.
- Open CMake GUI and select source (C:/lib/OpenCV2413/sources) and build (C:/lib/OpenCV2413/build) Path
- Click on `Configure` and Select "Microsoft Visual Studio 2015 x64"
- Click on `Generate` - Microsoft Visual Studio project gets generated
- Open `OpenCV.sln` in Visual Stduio from build path

**Building OpenCV**
- Select `Debug` and `RMB > Build` on `CMakeTargets > ALL_BUILD` in Project Explorer
- Select `Release` and `RMB > Build` on `CMakeTargets > ALL_BUILD` in Project Explorer
- OpenCV ist now built for/with Visual Studio 14

**Installing the library**
- Select `Debug` and `RMB > Build` on `CMakeTargets > INSTALL` in Project Explorer
- Select `Release` and `RMB > Build` on `CMakeTargets > INSTALL` in Project Explorer

**Set Environment/PATH Variable**
For CMake to find OpenCV

```bash
setx -m OPENCV_DIR "C:\lib\OpenCV2413\install\"
```

Set PATH variable, so linker finds libraries.
```bash
set PATH=%PATH%;C:\lib\OpenCV2413\install\x64\vc14
```

- **restart**

# OpenCV 3.x

## Unix

---------

## Windows

- go to http://opencv.org and download precompiled binaries (Visual Studio V12/14 is supported, otherwise you have to build the libraries for VS yourself)

**Set Environment Variable** (so CMake is able to find library)
```bash
setx -m OPENCV_DIR "C:\lib\OpenCV31\build"
```
**Add binary path to PATH variable** (so that DLLs can be included at runtime)
- Here: Visual Studio 14 x64 binaries
```bash
set PATH=%PATH%;C:\lib\opencv31\build\x64\vc14\bin;
```

### A. Precompiled Binaries

- Download and extract precompiled binaries: https://sourceforge.net/projects/opencvlibrary/files/opencv-win/
- OpenCV 3.1 already includes precompiled binaries for VS14

**Set Environment Variable**
```bash
setx -m OPENCV_DIR "C:\lib\OpenCV31\build"
```

### B. Building from Source (Microsoft Visual Studio)
**Requirements**
- Microsoft Visual Studio 12 or higher

**Building the project**
1. Download and install CMake
2. Generate Visual Studio project: Visual Studio is the default generator under Windows but x64 version maybe needs to be specified. Visual Studio is the default generator under Windows but x64 version maybe needs to be specified.
Open command prompt and execute:
```bash
mkdir build
cd build
cmake .. -G "Visual Studio 14 2015 Win64"
```

3. Build and install project with Visual Studio as described in OpenCV 2.4 Section
