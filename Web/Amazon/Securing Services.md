# Securing Services on AWS





### Security

- Networking: all services except api that schedules tasks in public subnet, rest in private subnet. Access to ECR through AWS private link

- Security groups: limit traffic to private network if possible, block out traffic

  

- DynamoDB?

-  AWS Key Management Service (KMS)

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

- Multiple AWS accounts
- Multiple VPCs
- Tiers of Subnets layered on top of each other
- Layering Security Groups with network ACLS
- Redundant clusters
- Load Balancers
- Etc.



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



**IAM policies vs. S3 policies**

Use IAM policies if:

- You need to control access to AWS services other than S3.  IAM policies will be easier to manage since you can centrally manage all of your permissions in IAM, instead of spreading them between IAM and  S3.
-  You have numerous S3 buckets each with different  permissions requirements. IAM policies will be easier to manage since  you don’t have to define a large number of S3 bucket policies and can  instead rely on fewer, more detailed IAM policies.
- You prefer to keep access control policies in the IAM environment.

Use S3 bucket policies if:

- You want a simple way to grant [cross-account access](http://docs.aws.amazon.com/AmazonS3/latest/dev/AccessPolicyLanguage_UseCases_s3_a.html) to your S3 environment, without using [IAM roles](http://docs.aws.amazon.com/IAM/latest/UserGuide/cross-acct-access-walkthrough.html).
- Your IAM policies bump up against the size limit (up to 2 kb for users, 5 kb for groups, and 10 kb for roles). S3 supports bucket  policies of up 20 kb.
- You prefer to keep access control policies in the S3 environment.







## Best Practices per Service



### Networking





### S3

- encryption
- restrict policy
- use "least privilege" IAM policies
  - e.g. only allow reads: `s3:read`





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

