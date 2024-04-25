# Bash

**`.bash_profile` vs `.bashrc`**



## Users

**Changing a password**

`passwd username`





## Output Piping

https://wiki.ubuntuusers.de/Shell/Umleitungen/



### Redirection `>`

- allows to redirect stdout, e.g. into a file



### Pipe Operator `|`

- Data flows from left to right
- Syntax: `command_1 | command_2 | command_3 | .... | command_N `
- Can be used to redirect `stdout` to `stdin` of other command







```
command1 | xargs -I{} command2 {}
```



## Scripting



**01. Create a script that takes an argument**

```bash
#!/bin/bash

# Check if argument is provided
if [ $# -eq 0 ]; then
    echo "Usage: my_script.sh <argument>"
    exit 1
fi

# Access the first argument
arg="$1"

# Execute your desired command using the argument
echo "Argument provided: $arg"
# Replace the following line with your actual command that uses the argument
# For example:
# python /path/to/script.py "$arg"
```

**02. Make it executable**

`chmod +x my_script.sh`

**03. Setup an alias**

```bash
echo "alias myalias='/path/to/my_script.sh'" >> ~/.zshrc
```

**04. Source the config and use the command**

```
source ~/.zshrc
my_alias some-argument
```





## File Permissions

- `sudo -s` Start a shell with superuser rights (usually as user `root`)
- `sudo -su the_username` Starts a new shell with superuser rights under the user `the_username` (prevent access rights conflicts) 

- display the file permissions:
  -  `ls -l`




## SSH

1. Generate Key `ssh-keygen` (will create a public, `id_rsa.pub`, and a private key `idrsa`)
2. Add to server: Installs the key as an authorized key on the server. Grants access to server without a password.
   - Copy default key: `ssh-copy-id user@host`
   - Copy specific key: `ssh-copy-id -i ~/.ssh/mykey user@host` (`mykey` entered as keyname during `ssh-keygen`)



## Rsync

- `v` verbose
- `a` archive
- `z` compress
- `r` recursive



**Copy** from **local** to **remote**

```bash
rsync -avzh /from/local /to/local
```

**copy FROM remote**

```bash
rsync -chavzP --stats --exclude="_build" user@<remote-ip>:/dir/on/remote /local/folder
```

**copy specific file FROM remote**

```bash
rsync -avz root@<remote-ip>:/var/www/public_html/ /var/www/public_html/.htaccess
```

**copy TO remote**

```bash
rsync -avz --exclude=.git --exclude=_build --exclude=.idea /my/local/path user@remote.com:/path/on/remote
```





## Misc Commands

**Downloading files**

`wget http://theurl/file.zip `

**Unzipping files**

...

**Moving files**

`mv /path/to/source /path/to/destination`

**Searching in source**

`grep MySearchString`

`grep "and$"`

**Delete folder with certain name**

`find /tmp -type d -name 'graphene-80*' -delete`

or

`sudo rm -rf ./2020-06-*`