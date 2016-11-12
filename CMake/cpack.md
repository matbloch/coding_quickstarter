
# CPack


It uses the generators concept from CMake, to abstract package generation on specific platforms, and it can be used with or without CMake.

Using either a simple configuration file or the CMake module, a complex project can be packaged into an installer. 


CPack can be used directly by specifying a CPackConfig.cmake file

- cpack runs
- it includes CPackConfig.cmake
- it iterates over the generators listed in that file’s CPACK_GENERATOR list variable (unless told to use just a specific one via -G on the command line...)
- foreach generator, it then
	sets CPACK_GENERATOR to the one currently being iterated
	includes the CPACK_PROJECT_CONFIG_FILE
	produces the package for that generator
	
	
	
These variables can also be overwritten on the command line using the option "-D":

cpack -D CPACK_PACKAGE_VENDOR=Me -D CPACK_SYSTEM_NAME=super-duper-linux ...
