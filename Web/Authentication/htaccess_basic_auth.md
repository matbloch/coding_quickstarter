## Basic Auth with htaccess



1. Create `.htaccess` file:

```
AuthName "Restricted Area" 
AuthType Basic 
AuthUserFile /var/www/web86/html/crosswind.ch/.htpasswd
AuthGroupFile /dev/null 
Require valid-user
```

2. Generate `.htpasswd` file:

