# UNIX





### Sudo

- `sudo -s` Start a shell with superuser rights (usually as user `root`)
- `sudo -su the_username` Starts a new shell with superuser rights under the user `the_username` (prevent access rights conflicts) 



### SSH

1. Generate Key `ssh-keygen` (will create a public, `id_rsa.pub`, and a private key `idrsa`)

2. Add to server: Installs the key as an authorized key on the server. Grants access to server without a password.

   - Copy default key: `ssh-copy-id user@host`
   - Copy specific key: `ssh-copy-id -i ~/.ssh/mykey user@host` (`mykey` entered as keyname during `ssh-keygen`)

   

**Best Practices**







