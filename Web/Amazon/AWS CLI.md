# AWS Command Line Interface (CLI)



## Prerequisites

### Identity and Access Management (IAM)





### Creating an IAM Admin User and Group

1. Open the [IAM Management Console](https://console.aws.amazon.com/iam/)

2. Navigate to "Users" > "Add User"
3. Select the access types: API & CLI access, AWS management console (online dashboard)
4. Select a user group





## Setup

1. Download the AWS CLI

2. Create an AWS user through the AWS management console that has API access

   - Go to the AWS [IAM](https://console.aws.amazon.com/iam/)
   - Create a user

3. Configure the AWS CLI Profile locally (will show dialog to enter the configured user credentials)

   `aws configure`

4. On the AWS management console navigate to the new user and choose the "Security credentials"

5. Use the displayed "Access Key ID" and "Secret access key" for the cli configuration

   - Create a new one if you forgot the secret key, by clicking on "Create access key"

6. Select the default region you operate ECS in, e.g. `us-east-2`

7. Information will be stored in a **profile** that is used every time AWS CLI prompts are executed

8. Display your profiles:

   `cat %USERPROFILE%\.aws\credentials`  (Windows) or `~/.aws/credentials` (Linux & Mac)





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

