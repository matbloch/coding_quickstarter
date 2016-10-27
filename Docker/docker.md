


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



### Networking with boot2docker
- boot2docker manages additional routing between VirtualBox system and the host system

1. Start Container
```bash
winpty docker run -it -p 80:80 matbloch/user_identification_node //bin/bash
```
1. List Containers
```bash
docker ps
```
2. Inspect Container
```bash
docker inspect f05e77f4897d
```

3. Get Container IP directly
```bash
docker inspect -f '{{ .NetworkSettings.IPAddress }}' f05e77f4897d
```
4. Ping Container from inside boot2docker
- from boot2docker shell, execute (172.17.0.2 is the container IP received in the last step):
```bash
ping 172.17.0.2
```


- Ping Boot2Docker from Host - OK
```bash
ping 192.168.99.100
```

- Ping Container from inside other container: OK
```bash
winpty docker run -it debian //bin/bash
ping 172.17.0.2
```
- Ping Container from inside other container by name: OK
```bash
winpty docker run -it --name deb_container debian //bin/bash
```

- Check if port is open
**Boot2Docker**:
```bash
winpty docker run -it -p 80:80 ubuntu
curl -I http://172.17.0.11:5050/
```
**Host**:
```bash
telnet 172.17.0.2 80
```


$ docker run -d --name redis redis



**Port Publishing**

```bash
docker run -p 8888:8080 myimg
```
- Publish port 8080 of container to port 8888 on host

-------------

#### Examples (Windows)

##### 01. Setup Port Mapping with Boot2Docker


**Test Mapping**
1. Start nginx server with open port 80
```bash
winpty docker run --rm -i -t -p 80:80 nginx
```
2. Access from inside boot2docker
```bash
curl -I http://localhost:80/
```
3. Access from Host system
```bash
telnet localhost 80
```

----------

##### 02. Start Docker Container

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

----------

##### 03. Mount Host Directory

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

----------


##### 04. Permanently running a container
- ...

## 03. Commands

- `[CTRL]` + `[D]` exit container bash
- `docker images` list all downloaded images
- `docker run image-name` load image `image-name` into new container (downloads it from dockerhub if not present)
- List active containers: `docker pl`
- To remove a container: docker rm <Container ID>
- To remove all containers: docker rm $(docker ps -a -q)
- To remove images: docker rmi <Container ID>
- To remove all images: docker rmi $(docker ps -a -q)


## 04. Automated Build: Docker Files


- `ADD <src> <dest>`

```bash


# run bash commands
RUN cd ~/openface && \
    ./models/get-models.sh && \
    pip2 install -r requirements.txt && \
    python2 setup.py install && \
    pip2 install -r demos/web/requirements.txt && \
pip2 install -r training/requirements.txt

# execute script through bash
CMD /bin/bash -l -c '/root/openface/demos/web/start-servers.sh'
```



## 05. Other Tutorials

- [Containerize Python Web Application](https://www.digitalocean.com/community/tutorials/docker-explained-how-to-containerize-python-web-applications)
