
## Wordpress & PHP-MyAdmin

```bash
version: '2'
services:
  # Wordpress service
  wordpress:
    depends_on:
      - db
    image: wordpress:4.6
    restart: always
    volumes:
      # share wp-content with host
      - ./wp-content:/var/www/html/wp-content 
    environment:
      WORDPRESS_DB_HOST: db:3306    # port necessary?
      WORDPRESS_DB_PASSWORD: p4ssw0rd!
    ports:
      - 80:80  # default http port: access through localhost:80 or localhost on host 
      - 443:443  # default https port: access through localhost:443 on host
    networks:
      - back
  # database (MySQL) service
  db:
    image: mysql:5.7
    restart: always
    volumes:
       # share mysql folder with host
       - db_data:/var/lib/mysql
    environment:
      MYSQL_ROOT_PASSWORD: p4ssw0rd!
    networks:
      - back
  # phpmyadmin service
  phpmyadmin:
    depends_on:
      - db
    image: phpmyadmin/phpmyadmin
    restart: always
    ports:
      - 8080:80  # access through localhost:8080 on host
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: p4ssw0rd!
    networks:
      - back
networks:
  back:
volumes:
  db_data:
```

## Distributed MySQL service
```bash
version: '2'
services:
mysql:
  build: mysql
  environment:
    MYSQL_USER: dbuser
    MYSQL_PASSWORD: dbpassword
    MYSQL_ROOT_PASSWORD: dbrootpassword
    MYSQL_DATABASE: dbdatabase
  volumes_from:
    - datastore
phpmyadmin:
  image: phpmyadmin/phpmyadmin
  links:
    - mysql
  environment:
    PMA_HOST: mysql
    PMA_PORT: 3306
  ports:
    - '8080:80'
datastore:
  image: busybox
  volumes:
    - /var/lib/mysql
```



## Wordpress & Data persistence & A3 Backup/Restore

```bash
web:
  image: wordpress
  links:
    - mysql
  environment:
    - WORDPRESS_DB_PASSWORD=myPass
  working_dir: /var/www/html
  volumes_from:
    - data
  ports:
    - "80:80"
mysql:
  image: tutum/mysql
  volumes_from:
    - data
  environment:
    - MYSQL_PASS=myPass
    - MYSQL_DATABASE=wordpress
data:
  image: busybox
  volumes:
    - /var/www/html/wp-content
    - /var/lib/mysql
backup:
  image: tutum/dockup
  volumes_from:
    - data
  environment:
    - AWS_ACCESS_KEY_ID=<ACCESS_KEY>
    - AWS_SECRET_ACCESS_KEY=<SECRET>
    - AWS_DEFAULT_REGION=eu-west-1
    - BACKUP_NAME=my-blog-backup
    - PATHS_TO_BACKUP=/var/lib/mysql /var/www/html/wp-content
    - S3_BUCKET_NAME=wordpress-backups
    - RESTORE=false
restore:
  image: tutum/dockup
  volumes_from:
    - data
  environment:
    - AWS_ACCESS_KEY_ID=<ACCESS>
    - AWS_SECRET_ACCESS_KEY=<SECRET>
    - AWS_DEFAULT_REGION=eu-west-1
    - BACKUP_NAME=my-blog-backups
    - PATHS_TO_BACKUP=/var/lib/mysql /var/www/html/wp-content
    - S3_BUCKET_NAME=wordpress-backups
    - RESTORE=true
```