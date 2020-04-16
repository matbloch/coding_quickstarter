# Independently Scalable Microservices

Source: 

https://aws.amazon.com/de/getting-started/projects/break-monolith-app-microservices-ecs-docker-ec2



![deployment-to-amazon](img/deployment-to-amazon.png)

1. Dockerize application
2. Build Docker images
3. Tag the Docker images with according to the AWS ECR naming convention
4. Push to AWS ECR
5. Deploy in a service an ECS



### 1. Build the Docker Images

- Keep in mind: Some AWS instances run on ARM, you might have to cross-compile your images (see cross-compilation documentation for Docker)



### 2. Tag and Push to ECR

- see the Elastic Container Registry documentation



### 3. Deploy to ECS















## Misc Topics



### Inter-Container Communication

**Inside same container**

Containers that are collocated on a single container instance may be able to communicate with each other without requiring links or host port mappings. Network isolation is achieved on the container instance  using security groups and VPC settings.

##### Inside same task

In network mode, you have to define two containers in the same task  definition and then mentioned the name of the container in the link.

**Different tasks**

Through service discovery:

- A task from one Amazon ECS service can connect with any other task in another Amazon ECS service.
- Tasks can connect to each other directly (without going through load balancers).
- Task IP addresses (and optionally, ports) in the Amazon ECS service are updated whenever tasks are started or stopped.





### Managing/Inspecting Clusters

https://medium.com/faun/deploy-application-on-ecs-in-minutes-8bfb109bd9bb



- Navigate to "CloudFormation" in the AWS console
- Select your stack
  - 

**VPC**

- Navigate to "Load Balancer" serction of the ECS console

**Internet Gateway**

- virtual router that connects a VPC to the internet



### Exposing a Task to the Public

The Application Load Balancer (ALB) lets your service accept incoming traffic

**During Task Definition:**

- In the "Elastic load balancing" section, specify the container name and the port to expose

  `simple-app:80`

- Select `HTTP` as ELB listener protocol

- Select `80` as ELB listener port

**Defining Target group for ALB**

- Go to EC2 console
- Go to "Target Groups" under "Load Balancing"
- Select the VPC of your cluster
- After creating the target group: Make the EC2 instances of your cluster were added as targets
  - Select "Target Groups" from the "Load Balancing" Tab
  - Select the "Targets" tab
  - Check the "Registered targets" and verify that your instances have been added
  - If not, add them by clicking "Edit"

**Creating the ALB**

- Navigate to "Load Balancers" and create a new one

- Select scheme "internet-facing" (will expose your application to the internet)

- Select the VPC of your cluster

- Select subnets from your availability zone

- Select a security group

  - select default ECS security group (all sources to port 80)
  - or create a new one

- Select the created target group (the service you want to expose to the internet)

- Verify that your service is accessible:

  -  Select "Load Balancers" from the "Load Balacing" Tab

  - Open the DNS name (A Record) in the "Description" Tab of your load balancer, e.g.:

    `celery-flask-8413341.us-east-2.elb.amazonaws.com`

**Trouble Shooting**

- See [the docs](https://docs.aws.amazon.com/elasticloadbalancing/latest/application//load-balancer-troubleshooting.html) for a list of error codes and how to resolve them



### Updating a Service

If tag `latest` is specified:

- Update service and select "Force new deployment" (no need to update the task definition)





### AWS Resource Management using the CLI

Launching a cluster

```bash
aws cloudformation deploy \
   --template-file infrastructure/ecs.yml \
   --region <region> \
   --stack-name Nodejs-Microservices \
   --capabilities CAPABILITY_NAMED_IAM
```

Task definitions from json

```json
{
    "containerDefinitions": [
        {
            "name": "[service-name]",
            "image": "[account-id].dkr.ecr.us-west-2.amazonaws.com/[service-name]:[tag]",
            "memoryReservation": "256",
            "cpu": "256",
            "essential": true,
            "portMappings": [
                {
                    "hostPort": "0",
                    "containerPort": "3000",
                    "protocol": "tcp"
                }
            ]
        }
    ],
    "volumes": [],
    "networkMode": "bridge",
    "placementConstraints": [],
    "family": "[service-name]"
}
```



























-------------------



## Terminology

https://hackernoon.com/microservices-on-fargate-part2-f29c6d4d708f

A VPC is simply a logically isolated chunk of the AWS Cloud.

Our VPC has two public subnetworks since it’s a requirement for an  Application Load Balancer. The nginx container will use them too.

Then we will isolate backend and frontend to a private subnet so they can’t be reached directly from the Internet.




