# Independently Scalable Microservices



https://hackernoon.com/microservices-on-fargate-part2-f29c6d4d708f







A VPC is simply a logically isolated chunk of the AWS Cloud.

Our VPC has two public subnetworks since it’s a requirement for an  Application Load Balancer. The nginx container will use them too.

Then we will isolate backend and frontend to a private subnet so they can’t be reached directly from the Internet.



#### Internet Gateway

Allows communication between the containers  and the internet. All the outbound traffic goes through it. In AWS it  must get attached to a VPC.

All requests from a instances running  on the public subnet must be routed to the internet gateway. This is  done by defining routes laid down on route tables.



#### Network Address Translation (NAT) Gateway

When an application  is running on a private subnet it cannot talk to the outside world. The  NAT Gateway remaps the IP address of the packets sent from the private  instance assigning them a public IP so when the service the instance  wants to talk you replies, the NAT can receive the information (since  the NAT itself is public-facing and reachable from the Internet) and  hand it back to the private instance.

An Elastic IP needs to be associated with each NAT Gateway we create.

The reason why we traffic private tasks’ traffic through a NAT is so tasks  can pull the images from Docker Hub whilst keeping protection since  connections cannot be initiated from the Internet, just outbound traffic will be allowed through the NAT.

#### Routes and Route Tables

Route tables gather together a set of routes. A route describes where do  packets need to go based on rules. You can for instance send any packets with destination address starting with 10.0.4.x to a NAT while others  with destination address 10.0.5.x to another NAT or internet gateway (I  cannot find a proper example, I apologise). You can describe both in and outbound routes.

The way we associate a route table with a subnet is by using *Subnet Route Table Association* resources, pretty descriptive.



### Security

Security groups act as firewalls between inbound and outbound communications of the instances we run.

We need to create a security group shared by all containers running on  Fargate and another one for allowing traffic between the load balancer  and the containers.

The stack has one security group with two ingress (inbound traffic) rules:

1. To allow traffic coming from the Application Load Balancer *(PublicLoadBalancerSecurityGroup)*
2. To allow traffic between running containers *(FargateContainerSecurityGroup)*



### Load Balancer

The Application Load Balancer (ALB) is the  single point of contact for clients (users). Its function is to relay  the request to the right running task (think of a task as an instance  for now).

> In our case all requests on port 80 are forwarded to nginx task.

To configure a load balancer we need to specify a *listener* and a *target group*. The listener is described through rules, where you can specify  different targets to route to based on port or URL. The target group is  the set of resources that would receive the routed requests from the  ALB.

This target group will be managed by Fargate and every time a new instance of nginx spins up then it will register it automatically  on this group, so we don’t have to worry about adding instances to the  target group at all.

#### Service Discovery

In our application, we want the backend to be reachable at *ecsfs-backend.local*, the frontend at *ecsfs-frontend.local*, etc… You can see the names are suffixed with *.local.* In AWS we can create a ***PrivateDnsService\*** resource and add services to them, and that would produce the aforementioned names, that is, `.`.

By creating various DNS names under the same namespace, services that get  assigned those names can talk between them, i.e. the frontend talking to a backend, or nginx to the frontend.

The *IP* addresses  for each service task are dynamic, they change, and sometimes more than  task might be running for the same service… so… how do we associate the  DNS name with the right task? 🤔 Well we don’t! Fargate does it all for  us.