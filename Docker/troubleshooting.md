# Docker Troubleshooting


#### Port Binding Fails
` Error starting userland proxy: mkdir /port/tcp:0.0.0.0:80:tcp:172.17.0.2:80: input/output error`
- Restart Docker Daemon


#### Can't push/pull to Dockerhub

`Get https://registry-1.docker.io/v2/: net/http: request canceled while waiting for connection`
- Restart Docker Daemon or set DNS Server to 8.8.8.8

#### Cannot start container
`: No such file or directory`
- If .sh script is used: change line ending to UNIX style