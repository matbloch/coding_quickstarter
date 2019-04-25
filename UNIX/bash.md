# Bash


**`.bash_profile` vs `.bashrc`**


## SSH

- Keychains
- SSH
- Rsync

## Misc Commands

**Downloading files**

`wget http://theurl/file.zip `

**Unzipping files**

**Moving files**

`mv /path/to/source /path/to/destination`

## Rsync



**copy from remote**

```bash
rsync -chavzP --stats --exclude="_build" user@<remote-ip>:/dir/on/remote /local/folder
```

**copy specific file from remote**

```bash
rsync -avz root@<remote-ip>:/var/www/public_html/ /var/www/public_html/.htaccess
```