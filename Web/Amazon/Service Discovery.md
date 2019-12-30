# Service Discovery



**Requirements**

- all services must be in the same subnet





#### Service Discovery

In our application, we want the backend to be reachable at *ecsfs-backend.local*, the frontend at *ecsfs-frontend.local*, etc… You can see the names are suffixed with *.local.* In AWS we can create a ***PrivateDnsService\*** resource and add services to them, and that would produce the aforementioned names, that is, `.`.

By creating various DNS names under the same namespace, services that get  assigned those names can talk between them, i.e. the frontend talking to a backend, or nginx to the frontend.

The *IP* addresses  for each service task are dynamic, they change, and sometimes more than  task might be running for the same service… so… how do we associate the  DNS name with the right task? 🤔 Well we don’t! Fargate does it all for  us.



### Setup

- enable service discovery during creation of the ECS services
- during task creation:
  - use bridge/host network mode for `SRV` records
  - use awsvpc network mode for `A` record



To allow your tasks to communicate with each other, complete the following steps:

1. [Create a new service](https://docs.aws.amazon.com/AmazonECS/latest/developerguide/create-service-discovery.html) using service discovery.
2. [Confirm that tasks are running](https://docs.aws.amazon.com/AmazonECS/latest/developerguide/ecs_run_task.html) in the Amazon ECS service.
3. [Associate a private hosted zone](https://docs.aws.amazon.com/Route53/latest/DeveloperGuide/hosted-zone-private-associate-vpcs.html) with the correct Amazon Virtual Private Cloud (Amazon VPC).
4. [Enable DNS resolution](https://docs.aws.amazon.com/vpc/latest/userguide/VPC_DHCP_Options.html#AmazonDNS) for the Amazon VPC with AmazonProvidedDNS.





### Nginx and ECS Service discovery

- use variable to force Nginx to resolve address at runtime
- otherwise Nginx would not route to new containers

```
set $backend "api.local";
proxy_pass http://$backend:5000;
```

- nginx container network mode to "host" (?)







## Implementation



- Setting up ServiceDiscovery on Fargate

  https://aws.amazon.com/de/blogs/aws/amazon-ecs-service-discovery/

- Deleting a Service from ServiceDiscovery

  https://stackoverflow.com/questions/53370256/aws-creation-failed-service-already-exists-service-awsservicediscovery-stat

- Service Discovery Configuration Options

  https://stackoverflow.com/questions/56897754/not-able-to-make-aws-ecs-services-communicate-over-service-discovery









## Architecture Patterns

https://containersonaws.com

#### Public Service, Public Network

- A public facing endpoint designed to receive push notifications
- An edge service which needs to make outbound connections to other services on the internet

![public-subnet-public-lb](img/public-subnet-public-lb.png)

#### Public Service, Private Network

- A service which is public facing but needs an extra layer of security  hardening by not even having a public IP address that an attacker could  send a request directly to.
- A service which initiates outbound connections but to the public you  want those connections to **originate from a specific and limited set of  IP addresses** that can be whitelisted

![private-subnet-public-lb](img/private-subnet-public-lb.png)



#### Private DNS Service Discovery

**Use Cases**

- Private, internal service discovery
- Low latency communication between services
- Long lived bidirectional connections, such as gRPC.

**Configuration**

- Single private Subnet
- Containers inside the subnet can communicate to each other using their  internal IP addresses. But they need some way to discover each other’s  IP address.

**Service Discovery**

- Option 1: DNS
- Option 2: REST api

![private-subnet-private-service-discovery](img/private-subnet-private-service-discovery.png)

## Example





