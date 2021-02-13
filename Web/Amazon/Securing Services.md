# Securing Services on AWS



### General

- privilege checks with IAM user Access Advisor
- CloudTrail
- Tiers of Subnets layered on top of each other
- Layering Security Groups with network ACLS
- Multiple VPCs
- Redundant clusters
- Multi-AZ



### IAM

- IAM policies:
  - minimize risk of accidental privilege assignment: attach to group/roles rather than individual users
- Provision access through IAM roles instead of individual credentials
  - roles can be revoked if account is compromised
- Principle of least privileges
- Multi-factor authentication
- Rotate credentials
- Enforce strong password policy



### Networking

- Security groups: limit traffic to private network if possible, block out traffic
- Networking: all services except api that schedules tasks in public subnet, rest in private subnet. Access to ECR through AWS private link
- *network access control list (ACL)* is an optional layer of security  for your VPC that acts as a firewall for controlling traffic in and out of one or  more subnets.
- Use AWS PrivateLink
- with growth:
  - web application firewall on load balancer
  - e.g. CloudFront



### Networking

- Restrict access to instances from limited IP ranges using Security Groups
- Host in private, expose via ALB/ELB
- Internal containers expose random port



### PrivateLink / VPC Endpoints

- assign correct security group
- assign correct policy
- restrict access only to subnets that need access (rout table entries)
- VPC Flow Logs (audit trail of accepted/rejected connections)



### ECS

- Enable CloudWatch logs
- Use "assume role" instead of access keys
- Place in private subnet if possible
- Communication to other services through AWS Endpoints (PrivateLink)
- Use security groups as firewall



### Storage (S3)

- encryption at rest, options:
  - 
- bucket or IAM policy (IAM is preferred)
  - Example: bucket policy that restricts access to a source VPC Endpoint that is connected to a private network
  - Block public access
- use "least privilege" IAM policies
  - e.g. only allow reads: `s3:read`
- Data encryption in transit
  - Secure Socket Layer/Transport Layer Security (SSL/TLS) or client-side encryption
- Data encryption at rest
  - Server-side: Encryption with AES-256 (AWS generates unique encryption key for each file, master key is stored in save rotation)
  - Client-side: Encrypt data before storing, decrypt when receiving
- Protection against data loss/corruption
  - Enable data versioning
  - Cross-zone replication
  - Application-level backups





### DynamoDB

See [Documentation](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/best-practices-security-preventative.html)

- Use service endpoint that accepts HTTPS
- Encryption at rest through AWS Key Management System (KMS)
- IAM roles to authenticate access to DynamoDB (instead of specific users)
  - Use "least privilege" strategy
  - Use restrictive conditions
  - Use IAM policy with condition `aws:sourceVpce` to force access through a specific VPC DynamoDB endpoint
- Use a VPC endpoint and policies to access DynamoDB
  - policies attached to dynamodb endpoint control access to DynamoDB table
- Consider client-side encryption
  - Encrypt data in transit and at rest [see AWS DynamoDB Encryption Client](https://docs.aws.amazon.com/dynamodb-encryption-client/latest/devguide/what-is-ddb-encrypt.html)





### Elastic Load Balancer

> The primary entity that receives the request from Amazon Route 53 is an Internet-facing[ Elastic Load Balancer](https://aws.amazon.com/elasticloadbalancing/). There are multiple ways in which an ELB can be configured, as explained[ here](http://docs.aws.amazon.com/ElasticLoadBalancing/latest/DeveloperGuide/using-elb-listenerconfig-quickref.html).

- Use secure communication: HTTPS or TCP/SSL









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


