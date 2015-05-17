# Solutions (.sln and .suo)
	A solution may contain multiple projects. 

	> View > Solution explorer



# Projects
Projects are the building blocks of an application.

# Items

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