# Docker Cloud

- Docker Cloud simplyfies container deployment with an intuitive user interface
- Allows to deploy to external nodes (e.g. Amazon, Google) and also your own host



- [Link Amazon Web Services to Docker cloud](https://docs.docker.com/docker-cloud/cloud-swarm/link-aws-swarm/)


## Pushing/pulling images
- pushing and pulling images is integrated in the Docker CLI (Command Line Intervace)
- use `docker login` to autheticate with Dockercloud/Dockerhub website
- then `docker pull NAME[:TAG]` or `docker push NAME[:TAG]`



## Services

### Sloppy.io



### Amazon Elastic Container Service (ECS)
- Amazon authetication not integrated in Docker CLI
- You need to generate a token with the Amazon CLI that will expire in 36 hours


1. Install AWS CLI on your local machine [Amazon Tutorial](https://docs.aws.amazon.com/cli/latest/userguide/installing.html)
	- Option 1: Python client through pip `python -m pip install awscli` (needs adding the executable to PATH)
	- Option 2: Windows Installer

2. Setup AWS CLI

- Head to the Amazon Panel and switch to the IAM Settings
- Setup a new console user according to [this docu](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users_create.html)
- Select permission:
	- `AmazonECS_FullAccess`
	- `AmazonECSTaskExecution`
- `aws configure`
- Copy paste the Access key id from the IAM panel (from the user you've created)
- Copy paste the secret access key from the IAM panel
- Region: `eu-central-1`
- output format: `text`

3. Authorice Docker CLI with AWS
- `aws ecr get-login --no-include-email --region us-east-2`
-  Run the docker login command that was returned in the previous step. `docker login -u AWS -p .....`


## Problems

**Error response from demon**
- Windows 10: right click on docker's icon in the tray bar and select "Settings"

Then, on the Docker's window, select the "Network" section and change the DNS option from "Automatic" to "Fixed" and hit "Apply". Docker will restart itself after that. I putted the Google's DNS (8.8.8.8)



