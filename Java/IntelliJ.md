
1. **Java/JDK Installation**
Java™ Platform, Standard Edition Development Kit (JDK™).
2. **Include path in `PATH` global**
	Variable name  : PATH
Variable value : c:\Program Files\Java\jdk1.8.0_xx\bin;[exiting entries...]
3. **Eclipse Installation**
    [Download Package](http://efxclipse.bestsolution.at/install.html)

    - Eclipse 4.5.1 SDK
    - e(fx)clipse 2.1.0
    - ...

	
## Setup/Installation

**Java SDK/RE**
- Download and install Java SE Development Kit 8 (standard edition)
	- Install JDK (SDK). E.g. in `C:/lib/Java/JDK.8.XY`
	- Install JRE (runtime environment). E.g. in `C:/lib/Java/jdk1.8.0_144`

**IDE**
- Download and install Jetbrains IntelliJ
- Create new Project
- Select "Project SDK" > "New". Select JDK (SDK!) installation folder


## IntelliJ settings

**Select SDK**
- `File > Project Structure > Platform Settings > SDK` Press + and add JDK base path

**Select Source Folders**
Source Directories: Only the path under the source root is taken as a package. Any directory can be set as a source root. 
- `File > Project Structure > Project Settings > Modules > Sources`: Select Main/Test Source

**Select Resource Folders**
Resource Folders/Files are copied to the output folder during compialtion
- `File > Project Structure > Project Settings > Modules > Resources`: Select Main/Test Resource


![test_src.png](.\img\test_src.png)


**Adding External Packages**


Click File from File menu
Project Structure (CTRL + SHIFT + ALT + S on Windows/Linux, ⌘ + ; on Mac OS X)
Select Modules at the left panel
Dependencies tab
'+' → JARs or directories



## Shortcodes

`shift + F10` - Build

-----------

- `alt + return` On variable, set in contstructor
- `ctrl + insert` Create Getter/Setter methods