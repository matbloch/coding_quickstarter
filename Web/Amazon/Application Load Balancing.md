# Configuring Load Balancing



#### Load Balancer Definition

**General**

- select scheme: an internet-facing load balancer routes requests from clients over the internet to targets

- Listener: Select HTTP protocol and Load Balancer Port 80

  > A listener is a process that checks for connection requests, using the protocol and                  port that you configure. The rules that you define for a listener determine how the load balancer routes requests to its registered targets.

- select a port the load balancer should listen to

- select the VPC in which your containers live

- select a subnet (load balancer subnet must include availability zone of container instances)

**Security Group - Internet > ALB Listeners**

> A security group is a set of firewall rules that control the traffic for your task
>
> **NOTE:** Later in this topic, you create a security group rule for your container instances that allows traffic on all ports coming from the security group created here, so that the Application Load Balancer can route traffic to dynamically assigned host ports on your container instances.

- You must assign a security group to your load balancer that allows inbound traffic to the ports that you specified for your **listeners**. By default: 80

![alb-create-security-group](img/alb-create-security-group.png)

**Target Groups/Routing**

> Your load balancer routes requests to the targets in a target group using the target group settings that you specify, and performs health checks on the targets using the health check settings that you specify.

- Target type: `IP` or `Instance` (a specific EC2 instance)

  > If your service's task definition uses the `awsvpc` network mode (which is required for the Fargate launch type), you must choose `ip` as the target type, not  `instance`. This is because tasks that use the `awsvpc` network mode are associated with an elastic network interface, not an Amazon EC2 instance.

- Port: 80, the port the traffic is routed to
- VPC: the VPC your containers live in

**Registered Targets**

> Load balancer distributes traffic between the targets registered to its target groups.
>
> When associating a target group to an Amazon ECS service, ECS automatically registers/deregisters containers with your target group.

- skip

**Security Group - ALB > Containers**

> Allows inbound traffic from load balancer to container instances

- Type: All traffic
- Source: Custom > select name of the Application Load Balancer Security group, created to forward traffic on port 80 to the ALB listeners





