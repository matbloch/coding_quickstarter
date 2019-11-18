# Daemonizing Celery

> Daemonizing Celery application using Supervisor

- configuration path: `/etc/supervisor/conf.d/supervisord.conf`



**Configuration Example**

`supervisord.conf`

```ini
[supervisord]
; Run supervisor in the foreground - prevent Docker container from shutdown
nodaemon=true

[program:celery]
command = celery worker --app=app.celery.celery --loglevel=INFO
directory = %(here)s
; Supervisor will start as many instances of this program as named by numprocs
numprocs=1
startsecs = 5
; If true, this program will start automatically when supervisord is started
autostart = true
; May be one of false, unexpected, or true. If false, the process will never
; be autorestarted. If unexpected, the process will be restart when the program
; exits with an exit code that is not one of the exit codes associated with this
; process’ configuration (see exitcodes). If true, the process will be
; unconditionally restarted when it exits, without regard to its exit code.
autorestart = true
; Need to wait for currently executing tasks to finish at shutdown.
; Increase this if you have very long running tasks.
stopwaitsecs = 300
; Put process stderr output in this file
stderr_logfile = /dev/stderr/celery-error.log
stderr_logfile_maxbytes = 0
; Put process stdout output in this file
stdout_logfile = /dev/stdout/celery-worker.log
stdout_logfile_maxbytes = 0
```

**Running The Service**

```shell
supervisord
```

```shell
#! /usr/bin/env sh
exec /usr/bin/supervisord
```



## Appendix

**Environment Variables**

```ini
[program:example]
command=/usr/bin/example --loglevel=%(ENV_LOGLEVEL)s
```

