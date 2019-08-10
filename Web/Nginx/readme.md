# Nginx



### Directives
- Config file include order: `/etc/nginx/nginx.conf` includes `/etc/nginx/conf.d/*.conf`
- Display configuration: `cat /etc/nginx/nginx.conf`


- [Context Introduction](https://www.digitalocean.com/community/tutorials/understanding-the-nginx-configuration-file-structure-and-configuration-contexts)



### Event Context

- is used to set global options that affect how Nginx handles connections at a general level
- e.g. number of connections each worker can handle, selecting the connection processing technique to use

```
# main context, outside of any other context

events {
    # events context
    . . .
}
```



### HTTP Context

...

### Server Context

- declared withing `http` context
- allows **multiple declarations**

```
# main context

http {
    # http context
    server {
        # first server context
    }

    server {
        # second server context
    }
}
```

#### Location





## Example Configuration



### Basic Auth



