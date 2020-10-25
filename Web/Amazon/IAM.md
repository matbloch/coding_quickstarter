# IAM





https://stackoverflow.com/questions/50082732/what-is-exactly-assume-a-role-in-aws







## Identity and Access Management

**AWS identities**

- **AWS account root user:** Should only be used to perform emergency tasks. Best practice is to use the root only to create first IAM user [see docs](https://docs.aws.amazon.com/IAM/latest/UserGuide/best-practices.html#create-iam-users).
- **IAM user:** Identity created within AWS account that has specific custom permissions.
- **IAM role:** Has assigned policies that grant access to resources. Can be assigned to users.



You can have valid credentials to authenticate your requests, but unless you have permissions you cannot create or access Amazon DynamoDB resources. For example, you must have permissions to create an Amazon DynamoDB table.                                 



**Assuming a role means obtaining a set of temporary credentials  which are associated with the role and not with the entity that assumed  the role.**





#### Fargate

- task role
- task execution role





**IAM Policies**

IAM policies specify what actions are allowed or denied on what AWS  resources (e.g. allow ec2:TerminateInstance on the EC2 instance with  instance_id=i-8b3620ec). You attach IAM policies to IAM users, groups,  or roles, which are then subject to the permissions you’ve defined. In  other words, IAM policies define what a principal can do in your AWS  environment.





## Access Control Mechanisms

- Whenever an AWS principal issues a request to S3, the authorization decision depends on the **union of all the IAM policies, S3 bucket policies, and S3 ACLs that apply**.
- In accordance with the principle of **least-privilege**, decisions **default to DENY** and an explicit DENY always trumps an ALLOW.
  - For example, if an IAM policy grants access to an object, the S3 bucket  policies denies access to that object, and there is no S3 ACL, then  access will be denied. Similarly, if no method specifies an ALLOW, then  the request will be denied by default. Only if no method specifies a  DENY and one or more methods specify an ALLOW will the request be  allowed.





