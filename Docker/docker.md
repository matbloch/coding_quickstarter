# Docker





## Building Docker Images



### RUN/CMD/ENTRYPOINT

- `RUN ` 
  - executes command(s) in a new layer and creates a new image.
  - E.g. used for installing software packages.
- `CMD` 
  - sets *default* command that is executed when running the container without specifying a command
  - **Ignored** if container is run with with command
  - Example: `docker run -it <image> /bin/bash`  bash is executed instead of `CMD`
- `ENTRYPOINT` for configuration and setup routines
  - **Always executed**, also when container runs with command line parameters

#### Shell and Exec forms

- All instructions (`RUN`, `CMD`, `ENTRYPOINT`) can be specified in *shell* or *exec* form

**Shell Form**

- `<instruction> <command>`  (calls  `/bin/sh -c ` )
- shell processing happens (e.g. variable substitution)

```shell
RUN apt-get install python3
CMD echo "Hello world"
ENV name John Dow
ENTRYPOINT echo "Hello, $name"
```

**Exec Form**

- `<instruction> ["executable", "param1", "param2", ...]` 
- **NO** shell processing, executable is called directly

```shell
RUN ["apt-get", "install", "python3"]
CMD ["/bin/echo", "Hello world"]
ENTRYPOINT ["/bin/echo", "Hello world"]
```

The following will not work:

```shell
ENV name John Dow
ENTRYPOINT ["/bin/echo", "Hello, $name"]
```

**Running Bash**

- use *exec* form and call `/bin/bash`

```shell
ENV name John Dow
ENTRYPOINT ["/bin/bash", "-c", "echo Hello, $name"]
```









## Docker Containers







## Docker-Compose



**Default Configuration Files**

- `docker-compose.yml` contains base configuration
- `docker-compose.override.yml` override configuration and extensions



**Selecting Configuration Files**

- `docker-compose up`  
  - will automatically load `docker-compose.yml` and then the override `docker-compose.override.yml`
- `docker-compose up -f <composeFile1> -f <composeFile2>` will launch only the specified configurations











## Networking



 `docker network ls` 

https://docs.docker.com/v17.09/engine/userguide/networking/#bridge-networks



## Profiling

`docker stats`

- **Net I/O** Data being sent and received over the network (network traffic).
- **Block I/O** Amount of data reading/writing from block devices on the host. 
- **PIDs** Number of threads created by the running container. 



### Optimization

- Block I/O high: consider  leveraging other cloud solutions, such as an [in-memory cache](https://aws.amazon.com/elasticache/) or an object storage service such as [S3](https://aws.amazon.com/s3/).

 If we’re writing/reading lots of data, we might want to 

Depending on the type of work that we’re doing, we might want to consider offloading this processing work into other containers as part of a [microservice architecture](https://microservices.io/).