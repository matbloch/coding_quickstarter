# Securing Services on AWS





### Security

- Networking: all services except api that schedules tasks in public subnet, rest in private subnet. Access to ECR through AWS private link
- Security groups: limit traffic to private network if possible, block out traffic
- S3: 
  - encryption
  - restrict policy
- DynamoDB? AWS Key Management Service (KMS)
- SSL
- ECS
  - private link
- In general: Speak to S3 etc through VPC endpoint
  - VPC entpoint

- only load balancer in public subnets
- do catch any logs as possible, in S3
- structure AWS accounts
- with growth:
  - web application firewall on load balancer
  - e.g. CloudFront



- VPC endpoints
  - assign correct security group
  - assign correct policy
  - restrict access only to subnets that need access (rout table entries)



*network access control list (ACL)* is an optional layer of security  for your VPC that acts as a firewall for controlling traffic in and out of one or  more subnets.



## S3





https://aws.amazon.com/de/blogs/security/iam-policies-and-bucket-policies-and-acls-oh-my-controlling-access-to-s3-resources/