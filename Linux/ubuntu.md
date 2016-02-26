# Ubuntu 14.04


## Linux file system


### Folder Structure

- `/bin`	Common programs, shared by the system, the system administrator and the users.
- `/boot`	The startup files and the kernel, vmlinuz. In some recent distributions also grub data. Grub is the GRand Unified Boot loader and is an attempt to get rid of the many different boot-loaders we know today.
-` /dev`	Contains references to all the CPU peripheral hardware, which are represented as files with special properties.
- `/etc`	Most important system configuration files are in /etc, this directory contains data similar to those in the Control Panel in Windows
- `/home`	Home directories of the common users.
- /initrd	(on some distributions) Information for booting. Do not remove!
- `/lib`	Library files, includes files for all kinds of programs needed by the system and the users.
- `/opt`	Typically contains extra and third party software.
- `/root`	The administrative user's home directory. Mind the difference between /, the root directory and /root, the home directory of the root user.
- `/tmp`	Temporary space for use by the system, cleaned upon reboot, so don't use this for saving any work!
- `/usr`	Programs, libraries, documentation etc. for all user-related programs. Reserved for package management systems.
- `/var`	Storage for all variable files and temporary files created by users, such as log files, the mail queue, the print spooler area, space for temporary storage of files downloaded from the Internet, or to keep an image of a CD before burning it.

### Filestystems

ext4

### Paths



## Software Installation (configure, make, make install)

### configure


### make


### make install




## 3rd Party Packages


### dependencies
```bash
$ sudo apt-get -y install libopencv-dev build-essential cmake git libgtk2.0-dev pkg-config python-dev python-numpy libdc1394-22 libdc1394-22-dev libjpeg-dev libpng12-dev libtiff4-dev libjasper-dev libavcodec-dev libavformat-dev libswscale-dev libxine-dev libgstreamer0.10-dev libgstreamer-plugins-base0.10-dev libv4l-dev libtbb-dev libqt4-dev libfaac-dev libmp3lame-dev libopencore-amrnb-dev libopencore-amrwb-dev libtheora-dev libvorbis-dev libxvidcore-dev x264 v4l-utils unzip
```

### Eclipse C++

```bash
$ sudo apt-get install eclipse eclipse-cdt g++
```

### Opencv



**Installation**

nproc: number of cores


```bash
$ cd opencv-3.0.0-alpha
$ mkdir build
$ cd build
$ cmake -D CMAKE_BUILD_TYPE=RELEASE -D CMAKE_INSTALL_PREFIX=/usr/local -D WITH_TBB=ON -D WITH_V4L=ON -D WITH_QT=ON -D WITH_OPENGL=ON ..
$ make -j $(nproc)
$ sudo make install
```


## Packages