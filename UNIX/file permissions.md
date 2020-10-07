# File Permissions







![linux-file-permissions](img/linux-file-permissions.jpg)

This example:

- file permissions
- Owner: read, write, execute
- Group: read
- Others: read

**Displaying Permissions**

- `ls -l`

**Changing Permissions**

- `chmod +rwx filename` to add permissions.
- `chmod -rwx directoryname` to remove permissions.
- `chmod +x filename`to allow executable permissions.
- `chmod -wx filename` to take out write and executable permissions.



### Permission Numbers



drwxr-xr-x 2 root   root        4096 Sep  8 18:13 ad-hoc

drwxr-xr-x 4 gitlab gitlab 4096 Sep 21 15:35 ad-hoc



-rwxr-xr-x  1 matthias  staff  11169 Sep 22 10:55 nightly_sot.py

-rw-r--r--   1 matthias  staff  15929 Sep 22 14:48 compare_two_nightly_detection_databases.py