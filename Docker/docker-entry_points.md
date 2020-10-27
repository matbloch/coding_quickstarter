# Docker Container Entry Points



READ: https://aws.amazon.com/de/blogs/opensource/demystifying-entrypoint-cmd-docker/



https://docs.docker.com/engine/reference/builder/#entrypoint

-  `ENTRYPOINT`  
- needed to propagate Unix signals, e.g. `SIGTERM` from `docker stop <container>`





- used to initialize container at runtime

```bash
#!/bin/bash
set -e

if [ "$1" = 'postgres' ]; then
    chown -R postgres "$PGDATA"

    if [ -z "$(ls -A "$PGDATA")" ]; then
        gosu postgres initdb
    fi

    exec gosu postgres "$@"
fi

exec "$@"
```

