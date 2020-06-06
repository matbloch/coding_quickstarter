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