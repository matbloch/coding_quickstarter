# File Permissions







![linux-file-permissions](img/linux-file-permissions.jpg)

This example:

- file permissions
- Owner: read, write, execute
- Group: read
- Others: read

**Examples:**

- drwxr-xr-x

**Displaying Permissions**

- `ls -l`

**Changing Permissions**

`chmod [permission] [file_name]`

- `chmod +rwx filename` to add permissions.
- `chmod -rwx directoryname` to remove permissions.
- `chmod +x filename`to allow executable permissions.
- `chmod -wx filename` to take out write and executable permissions.



### Permission Numbers





### Changing Ownershp

Change file ownership:

```output
chown [user_name] [file_name]
```

Change group ownership:

```output
chgrp [group_name] [file_name]
```