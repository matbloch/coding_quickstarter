# CVAT

- a complete tutorial: https://www.v7labs.com/blog/cvat-guide

- why CVAT? https://viso.ai/computer-vision/cvat-computer-vision-annotation-tool/
- CVAT with FiftyOne: https://towardsdatascience.com/tools-to-annotate-and-improve-computer-vision-datasets-f9b99cdb0e04







### Local Setup

1. Install

```bash
git clone https://github.com/opencv/cvat
cd cvat
docker compose up -d
```

2. Create an admin account

```bash
docker exec -it cvat_server bash -ic 'python3 ~/manage.py createsuperuser'
```

3. Open GUI

head to http://localhost:8080



### Mounting local datasets

1. create a docker volute called `cvat_share`:

   ```bash
   docker volume create --name cvat_share --opt type=none --opt device=/Users/anon/cvat_share  --opt o=bin
   ```

2. create a `docker-compose.override.yml` file with the following content (note that we're connecting `cvat_share` and then exposing it to django):

   ```yaml
   services:
     cvat_server:
       volumes:
         - cvat_share:/home/django/share:ro
     cvat_worker_import:
       volumes:
         - cvat_share:/home/django/share:ro
   
   volumes:
     cvat_share:
       external: true
   
   ```

3. When defining tasks, select ...





### Trackers for annotation

- see https://opencv.github.io/cvat/docs/manual/advanced/ai-tools/#trackers



### Custom annotation format

- https://opencv.github.io/cvat/docs/contributing/new-annotation-format/





### Detectors

- see https://opencv.github.io/cvat/docs/manual/advanced/ai-tools/#detectors-models



### Semi-automatic/automatic annotation

- Install instructions: https://opencv.github.io/cvat/docs/administration/advanced/installation_automatic_annotation/
- Releases: https://github.com/nuclio/nuclio/releases
- download: https://github.com/nuclio/nuclio/releases/tag/1.8.14



**01. Start the Docker image**

up

```bash
docker compose -f docker-compose.yml -f components/serverless/docker-compose.serverless.yml up -d
```

down

```bash
docker compose -f docker-compose.yml -f components/serverless/docker-compose.serverless.yml down
```

**02. Installing the `nuctl` command line tool**

- head over to the nuclio release page https://github.com/nuclio/nuclio/releases
- download `nuclt` with the same version as specified in `components/serverless/docker-compose.serverless.yml`
- change to executable using `chmod +x nuctl`
- move it into the `cvat` folder
- use it `nuctl --help`



**03. Create a new project**

- `nuctl create project cvat`



**04. Launch a serverless client**

- display available functions: `nuctl get functions`
- Available models: https://github.com/opencv/cvat/tree/develop/serverless



```bash
./nuctl deploy --project-name cvat \
  --path serverless/openvino/omz/public/yolo-v3-tf/nuclio \
  --volume `pwd`/serverless/common:/opt/nuclio/common \
  --platform local
```



Siamese tracker

```bash
nuctl deploy --project-name cvat --path "./serverless/pytorch/foolwood/siammask/nuclio" --platform local
```









- how to use: https://opencv.github.io/cvat/docs/manual/advanced/automatic-annotation/





- serverless tutorial: https://opencv.github.io/cvat/docs/manual/advanced/serverless-tutorial/

- see available models: http://localhost:8080/models?page=1



### Controls

**Moving annotations**

- disable the pin annotation
- select the cursor tool [esc]
- click on the annotation and drag it

![operation-move](img/operation-move.png)