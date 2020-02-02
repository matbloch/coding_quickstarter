# Docker-Compose




## Commands
To execute docker-compose commands, `cd` to compose file in Shell/Windows Console.

- `docker-compose --help`: Show commands

**Building the services**

- `docker-compose build`

**Init services**

- `docker-compose up --build` build and start
- `docker-compose up -d --no-recreate`: Start services in background , container only created once

**List Services**
- `docker-compose ps`: List active services

**Start/Stop Containers**
- `ctrl` + `c`: Stop all docker containers if in foreground
- `docker-compose stop` Stops running containers without removing them
- `docker-compose stop data`: Stop specific "data" container
- `docker-compose start` Restart stopped containers

**Inspecting containers**

- `docker-compose ps` List the services

- ``docker exec -ti SERVICENAME bash`` Launch bash inside a container

**Stop and remove containers**

- `docker-compose down` Stops containers and removes containers, networks, volumes, and images created by up.



## Defining Services - Yaml config



**Basic Structure**





**Overriding configurations**



### 

### Extension Fields

- Start with `x-`
- Ignored by Compose
- Can be used in other part of the YAML (using YAML anchors)

```yaml
version: '3.4'

# Custom settings structure that is ignored by Compose
x-custom:
  items:
    - a
    - b
  options:
    max-size: '12m'
  name: "custom"
```



**Example**: Extending fields

```yaml
version: '3.4'
# logging settings
x-logging:
  &default-logging
  options:
    max-size: '12m'
# re-use the settings in the service definition
services:
  web:
    image: myapp/web:latest
    logging: *default-logging
  db:
    image: mysql:latest
    logging: *default-logging
```

**Example:** Merging fields

```yaml
version: '3.4'
x-volumes:
  &default-volume
  driver: foobar-storage
  
services:
  web:
    image: myapp/web:latest
    volumes: ["vol1", "vol2", "vol3"]
volumes:
  vol1: *default-volume
  vol2:
    << : *default-volume
    name: volume02
  vol3:
    << : *default-volume
    driver: default
    name: volume-local
```










## Data Persistency
**NOTE**: In DockerToolbox for Windows, folders of the host will only be shared if somewhere below C:/User, e.g. on Desktop.

**Share other folders:**
Example: App files at `c:/dev/project/app`
- In the VM settings share folder `c:/dev` at `/Users`
- In `.yml`: `volumes` `/Users/project/app:/app` (volume name is name of shared folder in VM)

### 3.1 Host-Based Persistence
Store MySQL data on host machine
```bash
...
db:
	...
    volumes:
    - ./db-data:/var/lib/mysql # share mysql folder with host
	...
```


### 3.2 Data containers

Commit data container to backup application state

```bash
version: '2'
services:
	# 1. Data container
    mysql-data:	# minimalistic data container for sql
        image: busybox
        container_name: mysql-data
        volumes:
            - /var/lib/mysql
            - /etc/mysql/conf.d
    # 2. Application container
    mysql:	# mysql service that needs data storage
      image: mysql
      container_name: mysql
      volumes_from:	# take data from mysql-data container
      	- mysql-data
```

### 3.3 Temporary Persistent

- Will be deleted after `docker-compose down`!!
- Volumes can be listet with `docker volume ls`

```bash
version: '2'
services:

 mysql:
  image: mysql
  container_name: mysql
  volumes:
    - mysql:/var/lib/mysql
...
volumes:
 mysql:
```



## Image Registries

### Dockerhub

- Create repository on dockerhub
- Configure build folder and image destination in `docker-compose.yml` (see example)
- `docker login`
- `docker-compose build`
- `docker-compose push`


```bash
version: '3'
services:
  service1:
    build: .
    image: localhost:5000/yourimage  # goes to local registry
  service2:
    build: .
    image: youruser/yourimage  # goes to youruser DockerHub registry
```

### Amazon Elastic Container Registry









## Deployment

### DockerCloud

- Executes services hosted on different linked Providers (e.g. Amazon etc.)
- Can be used to host webservice

**HowTo**

- Create Stack (bundle of services) at [Docker Cloud](https://cloud.docker.com/)