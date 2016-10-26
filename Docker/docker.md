


## 01. Installation


**Hosting**
- dockerhub.com

**Commands**
- [Links](https://docs.docker.com/engine/reference/commandline/)


## 02.Basics

**Image**
- Each Docker image references a list of read-only layers that represent filesystem differences.
- **Windows**: Docker needs Linux VM to manage Images - Docker images are stored (disk.vmdk) within a VirtualBox (boot2docker.img) VM at `%USERPROFILE%\.docker\machine\machines`


**Container**
- When you create a new container, you add a new, thin, writable layer on top of the underlying stack.
- All changes made to the running container - such as writing new files, modifying existing files, and deleting files - are written to this thin writable container layer. 

-----------

### Storage

**Data volumes**
- Volumes are initialized when a container is created. If the container’s base image contains data at the specified mount point, that existing data is copied into the new volume upon volume initialization. (Note that this does not apply when mounting a host directory.)
- Data volumes can be shared and reused among containers.
- Changes to a data volume are made directly.
- Changes to a data volume will not be included when you update an image.
- Data volumes persist even if the container itself is deleted.

#### Examples (Windows)

##### Start Docker Container

```bash
winpty docker run -p 9000:9000 -p 8000:8000 -t -i bamos/openface //bin/bash
```
- **Network Access**
    ```bash
    -p <port_in_container>:<equals_port_on_host>
    ```
- **Container Name**
    ```bash
    --name <your_custom_container_name>
    ```
- **Run Bash in Container**
	- Allocate a pseudo-tty
	- Keep STDIN open even if not attached
    ```bash
    -t -i //bin/bash
    ```
- **Run Python Script in Container**
    ```bash
    python app.py
    ```

##### Mount Host Directory

1. Open Virtualbox
2. Change shared folder of boot2docker to the target directory of your host system

![VM Settings](img/vm_settings_1.png)

```bash
$ docker run -d -P --name web -v /src/webapp:/webapp training/webapp python app.py
```

Mount host directory `/src/webapp` into the container `web` at `/webapp` (pre-existing content gets overloaded: accessible again if directory is unloaded)
**Windows**
```bash
docker run -d -p 8787:8787 -v /c/Users/foobar:/home/rstudio/foobar rocker/rstudio
```



##### Permanently running a container
- ...

## 03. Commands


- `docker run image-name` load image `image-name` into new container (downloads it from dockerhub if not present)
- List active containers: `docker pl`
- To remove a container: docker rm <Container ID>
- To remove all containers: docker rm $(docker ps -a -q)
- To remove images: docker rmi <Container ID>
- To remove all images: docker rmi $(docker ps -a -q)
