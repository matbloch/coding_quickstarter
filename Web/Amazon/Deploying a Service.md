# Deploying Micro Services to AWS





## General Setup

**Requirements**

- containers individually scalable > scaling is only possible on a per-task basis > single container per task

**Architecture**

- Nginx (frontend & reverse proxy)
  - ALB routes external traffic to port 80 on container. 
    - Configured security group: allow traffic from port 80 with the security group of the ALB listener as source
    - Container to load balance: Nginx with target group configured to forward port 80 form the ALB listener
  - Nginx redirects traffic from /api/* to http://api.local:5000 (`api.local` is a service discovery endpoint)
  - Nginx holds `api.local` in a variable so that the endpoint would be resolved at runtime, allowing routing to work also in case new tasks are added during upscaling
- Flask API
  - Exposes port 5000 to the VPC
  - Connects to Redis through port 6379
  - Available through service discovery at `api.local`
- Redis
  - Exposes port 6379 to the VPC
- Worker
  - Connects to Redis through port 6379



**Load Balancing**

> Configurable through EC2 > Load Balacing or Service Definition

- ALB
- Listener for port 80
- Security group: Accept traffic on port 80
- Target group: Redirect to VPC on port 80, Type IP, no assigned targets



**Service Discovery**

> Configurable through Service Definition, visible in Route53 console, editable through CLI

- namespace `local`
- using `A` records with `awsvpc` network mode



**Container Registry**

> ECS > Container Registry

- All images compiled for `arm64` to work on t-instances









## Issues/Questions





General

- is there a visualization available of my VPC, endpoints, subnets, ALB, services/tasks?
- When selecting the VPC and security group for a Fargate service, I can select the security group that is of target type "instance", eventhough Fargate doesn't use instances





VPCs

- default VPC?
- how to create/manage?
- subnets? what is it, what benefit?
- 



Service Discovery

- `srv` requires Nginx professional
- `A` records don't work if multiple tasks are run on the same EC2 instance since the number of ENIs is limited
- Only tutorial found is https://aws.amazon.com/de/blogs/aws/amazon-ecs-service-discovery/ on fargate



CloudFormation

- Why are Fargate instances shown as part of my cluster even if they use just any machine provided by AWS?



Load Balancing

- how to properly configure ALB?
- target type instance/ip?
- no rule means all traffic is blocked (whitelisting)?



Service/Task Configuration

- sometimes images are not being updated
- forced service re-deployment enough if `latest` image is selected?
- why do containers still show arm issue even if compiled for arm?
- How to inspect architecture of image hosted on ECR?



Redis

- how to configure security group to host redis on ECS?
- how to setup redis in elastiCache?





## Insights



**Load Balancer**

- can have multiple target groups, e.g. an instance type group to an EC2 instance and a fargate target (?)



**Security Group patterns**

Security group rules are implicit deny, which means all traffic is denied unless an inbound or outbound rule explicitly allows it. You can only add or  remove "allow" rules—you can't add or remove "deny" rules, and there's  no need to.



**Services need public IP address to fetch docker image**

- set `AssignPUblicIP: Enabled`
- due to lack of internet access to pull the image. The image pull occurs  over the network interface used by the Task, and as such shares security group and routing rules.
- without assigning a public IP, Fargate does not get access to ECR.

[Security groups](http://docs.aws.amazon.com/AmazonVPC/latest/UserGuide/VPC_SecurityGroups.html) provide customizable rules to control inbound and outbound traffic.   You can also choose to use NAT instead of adding a public IP address  which will also let you restrict inbound traffic.



**Services register their containers automatically to the selected target group**

```
service frontend registered 1 targets in target-group ECS-port-80
service frontend has started 1 tasks: task 47efca7c-fb75-4714-a351-82b28b0fea11.
```

**standard_init_linux.go:190: exec user process caused "exec format error"**

- FARGATE instances are linux/amd64



 **executable file not found in $PATH"**

- python: use python3 instead of python, e.g. `python3 start_debug.py`
- celery: use list format, e.g. `['celery', '-A', 'crossref.tasks', 'worker', '-l', 'INFO']`



**Redis security group**

In your instance it sounds like you should have a single inbound rule for the security group assigned to your ElastiCache Redis cluster. This rule for port `6379` should specify the security group assigned to your EC2 instance(s) in the "source" field. 

By specifying the security group ID in the source field, instead of  an IP address or IP range, you can easily scale-out your EC2 server  cluster, or make modifications to your EC2 instance that might result in an IP address change, without needing to change the security group  rules for your ElastiCache cluster.





### Security Groups

- [Rule reference](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide//security-group-rules-reference.html)

**Allow connections between instances within the same security group**

| Protocol type | Protocol number | Ports    | Source IP                    |
| ------------- | --------------- | -------- | ---------------------------- |
| -1 (All)      | -1 (All)        | -1 (All) | The ID of the security group |

**Allow HTTP requests from within the VPC**

| Protocol type | Source      | Ports |
| ------------- | ----------- | ----- |
| tcp           | 10.0.0.0/16 | 80    |



## VPCs and Public/Private Subnets

- https://www.assistanz.com/creating-vpc-public-private-subnets/

The Load Balancer should be your gateway to the cluster. When running a  web service, make sure you've running your cluster in a private subnet  and your containers cannot be accessed directly from the internet.  Ideally, your internal container should expose a random, ephemeral port  which is bound to a target group. Make sure also that traffic is only  allowed from the Load Balancer's Security Group.



**ELB (Elastic Load Balancer)**

- can be in public or private subnets
- can be in multiple subnets (e.g. across availability zones)
- public: connect service to internet
- private: routing e.g. between web and app tier



CIDR:

https://www.ionos.de/digitalguide/server/knowhow/classless-inter-domain-routing/



#### NAT Gateways

- Network Address Translation (NAT)

