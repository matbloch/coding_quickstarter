# Nginx

## Configuration File Structure

- All config files in  `/etc/nginx/`
- **primary config:** `nginx.conf`
  - includes `/etc/nginx/conf.d/*.conf`
- Nginx modules are controlled by *directives* in the configuration file



**Example:** Default Configuration ()

` /etc/nginx/nginx.conf  `

```nginx
user  nginx;
worker_processes  1;

error_log  /var/log/nginx/error.log warn;
pid        /var/run/nginx.pid;

events {
	worker_connections 1024;
}

http {
    #...
    # include additional configurations
    include /etc/nginx/conf.d/*.conf;
}
```



### HTTP Block

- contains directives for handling web traffic
- each website should have it's own configuration in `/etc/nginx/conf.d/`
  - format: `example.com.conf`
  - example at: ` /etc/nginx/conf.d/default.conf`

### Event Block

- is used to set global options that affect how Nginx handles connections at a general level
- e.g. number of connections each worker can handle, selecting the connection processing technique to use

```
# main context, outside of any other context
events {
    # events context
    . . .
}
```



### Snippets

**Displaying configuration**

`cat /etc/nginx/nginx.conf`



## Writing a Configuration

### 01. Server Blocks

- declared within `http` context
- `listen` for which port to use the config
- `server_name` for which domain to use the config

**Multiple declarations**

```
# main context
http {
    # http context
    server {
        listen: 80
    }
    server {
        listen: 81
    }
}
```

### 02. Location Blocks



### 03. Directives

#### try_files

-  Checks if files exists and if not, falls back to the next route



**Example**: Index fallback

-  Accessed route: `http://example.com/images/image.jpg` 
  - 1st condition `$uri`: check if file `image.jpg` is inside `/images`
  - 2nd condition `$uri/`: check if the path is a directory
  - 3rd condition/fallback: redirect to `index.html`

```nginx
location / {
    try_files $uri $uri/ /test/index.html;
}
```

**Example**: Default image

```nginx
location /images/ {
    try_files $uri /images/default.gif;
}
```

**Example**: Application routing fallback

- try to serve static files from `/static/`, else redirect request to application (and rewrite request parameters)

```nginx
location / {
    root /static/;
    index index.html
	try_files $uri @opencart;
}

location @opencart {
	rewrite ^/(.+)$ /index.php?_route_=$1 last;
}
```

#### Alias

- redirect calls to `/files/...` to a static folder

```nginx
location /files/ {
  alias /var/www/html/sites/default/files/;
}
```

#### Root

- will be used to search for a file
- can be placed at any level

```nginx
server {
    root /www/data;
    location / {
    }
    location /images/ {
    }
    location ~ \.(mp3|mp4) {
        root /www/media;
    }
}
```



## Inter-Process Communication

### Unix Sockets

-  is an inter-process communication mechanism that allows bidirectional  data exchange between processes running on the same machine. 
-  To be accessible via a socket, your program first creates a socket and  "saves" it to disk, just like a file. It monitors the socket for  incoming connections. When it receives one, it uses [standard IO methods](http://ruby-doc.org/core-2.2.2/IO.html#method-i-readline) to read and write data. 

### IP Sockets

 [IP sockets](http://en.wikipedia.org/wiki/Internet_socket) (especially TCP/IP sockets) are a mechanism allowing communication  between processes over the network. In some cases, you can use TCP/IP  sockets to talk with processes running on the same computer (by using  the loopback interface). 





# Example Configurations

- Config generator: https://nginxconfig.io/?0.php=false&0.python&0.django&0.root=false

### WSGI IPC

**Stack**

- Nginx (webserver, reverse proxy)
- Unix sockets
- WSGI
  - WSGI: python spec for IPC
  - uWSGI: application server for request translation (alternativ: Gunicorn)
  - uwsgi: Binary protocol implemented by the uWSGI server

**Goal**

-  server static files through Nginx
- proxy rest to application (e.g. api)



```
                  +--- host ----------> uWSGI on localhost:5000 ---> Flask
                  |
request > nginx --|--- host/static ---> html, js, css, images
```

```
the web client <-> the web server <-> the socket <-> uwsgi <-> Django
```

```nginx
server {
    listen 80;	# listen to port 80
    location / {
        try_files $uri $uri/ @app;
    }
    location @app {
        include uwsgi_params;	# specifies general uWSGI parameters that need to be set
        uwsgi_pass unix:///tmp/uwsgi.sock;	# temporary file for IPC
    }
    location /static {
        alias /web/app/static;
        root   /web/app/static;
        index  index.html;
    }
}
```



### Reverse Proxy

- forward requests to different applications

```
                  +--- host --------> node.js on localhost:8080
                  |
users --> nginx --|--- host/blog ---> node.js on localhost:8181
                  |
                  +--- host/mail ---> node.js on localhost:8282
```

- `node.js` servers apps from `/`
- Nginx forwards requests to `/blog` and `/mail`
- **Solution:** rewrite the url before the request is passed on

```nginx
server {
    listen       ...;
    ...
    location / {
        proxy_pass http://127.0.0.1:8080;
    }
    
    location /blog {
        rewrite ^/blog(.*) /$1 break;
        proxy_pass http://127.0.0.1:8181;
    }

    location /mail {
        rewrite ^/mail(.*) /$1 break;
        proxy_pass http://127.0.0.1:8282;
    }
    ...
}
```



### Compression/Gzip

- `gzip_static` (context: http, server, location)
- Enabled: Checks for precompressed files first

```nginx
location / {
    gzip_static on;
}
```

**Verifying that Gzp is enabled**

- Firefox:  Developer Tools > Network > Select file > Headers, check for `Content-Encoding: gzip



### Serving Static Content



### Basic Auth



