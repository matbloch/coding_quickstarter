# AWS Command Line Interface (CLI)





## Setup

1. Download the AWS CLI

2. Create an AWS user through the AWS management console that has API access

3. Configure the AWS CLI Profile

   `aws configure`

4. On the AWS management console navigate to the new user and choose the "Security credentials"

5. Use the displayed "Access Key ID" and "Secret access key" for the cli configuration

6. Select the default region you operate ECS in, e.g. `us-east-2`

7. Information will be stored in a **profile** that is used every time AWS CLI prompts are executed

8. Display your profiles:

   `cat %USERPROFILE%\.aws\credentials`  (Windows) or `~/.aws/credentials` (Linux & Mac)



## Identity and Access Management (IAM)







## Creating an IAM Admin User and Group

1. Open the [IAM Management Console](https://console.aws.amazon.com/iam/)

2. Navigate to "Users" > "Add User"
3. Select the access types: API & CLI access, AWS management console (online dashboard)
4. Select a user group







## Misc Commands



**Listing CLI Configuration Data**

- `aws configure list`

```
      Name                    Value             Type    Location
      ----                    -----             ----    --------
   profile                <not set>             None    None
access_key     ****************ABCD      config_file    ~/.aws/config
secret_key     ****************ABCD      config_file    ~/.aws/config
    region                us-west-2              env    AWS_DEFAULT_REGION
```

