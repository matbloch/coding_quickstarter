
# Microsoft Visual Studio

[TOC]

### Hotkeys

- [CTRL] + M > L: Gesamte Gliederung auf-/zuklappen
- [CTRL] + M > M: Aktuelle Gliederung auf-/zuklappen
- [Alt] + Pfeil hoch: Zeile verschieben

### Fenster

**Datei 2x öffnen**
- Tab anklicken
- "Fenster" > "neues Fenster"

### Lesezeichen

Ansicht > Lesezeichenfenster

![lesezeichen.jpg](C:\Users\IT-Entwicklung\Desktop\Misc\Microsoft Visual Studio\img\lesezeichen.jpg)

### Version Control

![git_status.jpg](C:\Users\IT-Entwicklung\Desktop\Misc\Microsoft Visual Studio\img\git_status.jpg)


## File Structure

**project:**
```cpp
/solution
   /prj1
      /headers
        /module1
        /module2
      /resource
      /source
        /module 1
        /module 2
      /test
   /prj2
      /headers
        /module1
        /module2
      /resource
      /source
        /module 1
        /module 2
      /test
```

**files:**
/solution
    /prj1
       /bin
       /build
       /include
          /module1
          /module2
       /lib
       /res
       /src
          /module1
          /module2
       /test
    /prj2
       /bin
       /build
       /include
          /module1
          /module2
       /lib
       /res
       /src
          /module1
          /module2
       /test

## Build Configurations

**Structuring the Project**

- [RMB] on Project root: Add source files to project
- [RMB] on Project root > Add > New Filter: Folder to structure source files

![project_1.jpg](C:\Users\IT-Entwicklung\Desktop\Misc\Microsoft Visual Studio\img\project_1.jpg)

**Setup Build Configurations**
[RMB] in Project Explorer on Project name > Options

[Makro List](https://msdn.microsoft.com/en-us/library/c02as0cs.aspx)

Variables
- $(SolutionDir): The directory of the solution (defined as drive + path); includes the trailing backslash '\'.
- $(SolutionName): The base name of the solution.
- $(Configuration): The name of the current project configuration (for example, "Debug").
- $(ProjectName): The base name of the project.

**Build Actions**


![build_actions.jpg](C:\Users\IT-Entwicklung\Desktop\Misc\Microsoft Visual Studio\img\build_actions.jpg)

Source file path:

![source_path.jpg](C:\Users\IT-Entwicklung\Desktop\Misc\Microsoft Visual Studio\img\source_path.jpg)


### Header Files

Visual Studio looks for headers in this order

- in the current source directory
- in the Additional Include Directories in the project properties. (Under C++ | General)
- in the Visual Studio C++ Include directories under Tools | Options | Projects and Solutions | VC++ Directories.


## OpenCV
1. Install OpenCV (Pre-built Libraries, self-extraxting archive) to C:/Software/ (this will create a folder named "opencv" in /Software)
2. Setup environement variables. Type into **cmd**:
``setx -m OPENCV_DIR C:\Software\opencv\Build\x86\vc10``     (suggested for Visual Studio 2010 - 32 bit Windows)
``setx -m OPENCV_DIR C:\Software\opencv\Build\x64\vc10``     (suggested for Visual Studio 2010 - 64 bit Windows)
``setx -m OPENCV_DIR C:\Software\opencv\Build\x86\vc11``     (suggested for Visual Studio 2012 - 32 bit Windows)
``setx -m OPENCV_DIR C:\Software\opencv\Build\x64\vc11``     (suggested for Visual Studio 2012 - 64 bit Windows)
``setx -m OPENCV_DIR C:\Software\opencv\Build\x86\vc12``     (suggested for Visual Studio 2013 - 32 bit Windows)
``setx -m OPENCV_DIR C:\Software\opencv\Build\x64\vc12``     (suggested for Visual Studio 2013 - 64 bit Windows)
> • This variable should be visible under: 
``Systemsteuerung\System und Sicherheit\System > erweiterte Systemeinstellungen > Umgebungsvariabeln``
• If you type ``%opencv_dir%`` in explorer path, the opencv dir should open



## Kinect

• Setup VS with Kinect

Project > Properties:

1. Configuration Properties > C/C++ > General > Additional Include Directories > edit: C:/Program Files/Microsoft SDKs/Kinectv1.6/inc
2. Configuration Properties > Linker > General > Additional Library Directories > edit: C:Program FilesMicrosoft SDKsKinectv1.6libx86
3. Configuration Properties > Linker > Input > Additional Dependencies > edit: C:Program FilesMicrosoft SDKsKinectv1.6libx86Kinect10.lib