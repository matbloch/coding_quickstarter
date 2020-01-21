# Building Multi-Arch Images







## Setup

Source: [engineering.docker.com](https://engineering.docker.com/2019/04/multi-arch-images/)

1. Download Docker Desktop Edge release
2. Verify "Supported Platforms" in the "About" section



## Commands



- `docker buildx ls` view supported build architectures
- `docker image inspect  --format='{{.Architecture}}' my_image_name`







## Single-Arch Images





## Multi-Arch Images

**NOTE: ** Mulit-arch images are currently only supported on Dockerhub





```
docker buildx build --platform linux/amd64,linux/arm64,linux/arm/v7 -t adamparco/demo:latest --push .
```



- `--push` generates a multi-arch manifest and pushes all the images

