
# Docker-Compose

**Host Services at**: [Docker Cloud](https://cloud.docker.com/)

- Tool to define and run mutli-container docker applications (e.g. webapp + sql server)
- Integrated in DockerToolbox for Windows
- Additional `docker-compose.yml` for service configration


## 0. Deployment - DockerCloud
- Executes services hosted on different linked Providers (e.g. Amazon etc.)
- Can be used to host webservice

**HowTo**
- Create Stack (bundle of services) at [Docker Cloud](https://cloud.docker.com/)


## 1. Commands
To execute docker-compose commands, `cd` to compose file in Shell/Windows Console.

- `docker-compose --help`: Show commands


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

**Stop and remove containers**
- `docker-compose down` Stops containers and removes containers, networks, volumes, and images created by up.



## 2. Quickstart

1. Create `docker-compose.yaml`
1.1 Pull corresponding docker images `docker pull my_img`
1.2 Or... Build composition with: `docker-compose build`
2. Start console in directory `docker-compose.yaml` is located
3. List current services: `$ docker-compose ps`
4. Start services `$ docker-compose up`


### 2.1 Build Images with `docker-compose`

1. Configure shell for docker
2. head to `docker-compose.yml` file
3. `docker-compose build`: Builds all images (if `build` parameter specified)

### 2.2 Examples

**Wordpress & SQL container**
```bash
version: '2'
services:

  wordpress_container:
    image: wordpress
    # Expose ports. HOST:CONTAINER
    ports:
      - 8080:80
    # Link to containers in another service. SERVICE:ALIAS
    links:
      - mysql_container
    depends_on:
      - mysql_container
    # env variable for wordpress image
    environment:
       WORDPRESS_DB_PASSWORD: abc123

  mysql_container:
    image: mysql:latest
    # add environment password
    environment:
       MYSQL_ROOT_PASSWORD: abc123
```

## Communicate with Containers
**Access shell**
- `docker-compose exec SERVICENAME sh`
- `docker exec -i -t FOLDERNAME_SERVICENAME_1 bash`

Type `docker-compose ps` to list the full names of the services.


## 3. Data Persistency
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



## Examples


### Persistent MySQL + Export




```bash
version: '2'
services:
# mysql service
db:
image: mysql:5.7
restart: always
volumes:
   - db_data:/var/lib/mysql
environment:
  MYSQL_ROOT_PASSWORD: p4ssw0rd! # TODO: Change root password
  MYSQL_USER: 'test'	# create new user
  MYSQL_PASS: 'pass'	# create new user password
  MYSQL_DATABASE: wordpress  # create new db on startup
networks:
  - back
volumes:
  # share mysql folder with host
  - ./db-data:/var/lib/mysql

# phpmyadmin service
phpmyadmin:
depends_on:
  - db
image: phpmyadmin/phpmyadmin
restart: always
ports:
  - 8080:80
environment:
  PMA_HOST: db # link to database service
networks:
  - back
```

