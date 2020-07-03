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





## Managing Permissions



https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/access-control-overview.html



- Identiy-based Policies (IAM policies)
- Resource-Based Policies
  - Some services (e.g. S3) support resource-based policies. Policies can be attached to resources to manage permissions.





## Designing Policies

https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/access-control-overview.html



**Basic Policy Elements**

**Conditions**





## S3



https://aws.amazon.com/de/blogs/security/iam-policies-and-bucket-policies-and-acls-oh-my-controlling-access-to-s3-resources/









## Identity and Access Management

**AWS identities**

- **AWS account root user:** Should only be used to perform emergency tasks. Best practice is to use the root only to create first IAM user [see docs](https://docs.aws.amazon.com/IAM/latest/UserGuide/best-practices.html#create-iam-users).
- **IAM user:** Identity created within AWS account that has specific custom permissions.
- **IAM role:** Has assigned policies that grant access to resources. Can be assigned to users.





You can have valid credentials to authenticate your requests, but unless you have                                    permissions you cannot create or access Amazon DynamoDB resources. For example, you                                    must have permissions to create an Amazon DynamoDB table.                                 



## Best Practices per Service





### DynamoDB

See [Documentation](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/best-practices-security-preventative.html)

- Encryption at rest through AWS Key Management System (KMS)
- IAM roles to authenticate access to DynamoDB (instead of specific users)
  - Use "least privilege" strategy
  - Use restrictive conditions
  - Use IAM policy with condition `aws:sourceVpce` to force access through a specific VPC DynamoDB endpoint
- Use a VPC endpoint and policies to access DynamoDB
  - policies attached to dynamodb endpoint control access to DynamoDB table
- Consider client-side encryption
  - Encrypt data in transit and at rest [see AWS DynamoDB Encryption Client](https://docs.aws.amazon.com/dynamodb-encryption-client/latest/devguide/what-is-ddb-encrypt.html)

