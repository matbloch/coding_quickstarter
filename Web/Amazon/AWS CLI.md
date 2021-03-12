# AWS Command Line Interface (CLI)



## Prerequisites

### Identity and Access Management (IAM)





### Creating an IAM Admin User and Group

1. Open the [IAM Management Console](https://console.aws.amazon.com/iam/)

2. Navigate to "Users" > "Add User"
3. Select the access types: API & CLI access, AWS management console (online dashboard)
4. Select a user group





## Setup

**Install the Command Line Interface**

1. Download the [AWS CLI](https://aws.amazon.com/de/cli/)

**Create an AWS user and get an API access key**

1. Create an AWS user through the AWS management console that has API access

   - Go to the AWS [IAM](https://console.aws.amazon.com/iam/)
   - Create a user
2. On the AWS management console navigate to the new user and choose the "Security credentials"
3. Use the displayed "Access Key ID" and "Secret access key" for the cli configuration

   - Create a new one if you forgot the secret key, by clicking on "Create access key"

**Configuring the CLI**

1. Configure the AWS CLI Profile locally (will show dialog to enter the configured user credentials)

   `aws configure`

2. Select the default region you operate ECS in, e.g. `us-east-1`

3. Information will be stored in a **profile** that is used every time AWS CLI prompts are executed

4. Display your profiles:

   `cat %USERPROFILE%\.aws\credentials`  (Windows) or `~/.aws/credentials` (Linux & Mac)

## Configuring Multiple Profiles

### Through the CLI

- `aws configure --profile dev`
- `aws configure --profile prod`

### Manual Inspection

**Config paths**

- Unix: `~/.aws/credentials`
- Windows: `%UserProfile%\.aws\credentials`

**Defining Credentials**

`~/.aws/credentials`

```
[default]
aws_access_key_id=...
aws_secret_access_key=...

[user2]
aws_access_key_id=...
aws_secret_access_key=...
```

**Defining settings per account**

`~/.aws/config`

```
[default]
region=us-west-2
output=json

[profile user2]
region=us-east-1
output=text
```



## Switching Between AWS Profiles

> !!  does ***not\*** affect any command shell that is already running at the time you run the command

- UNIX:
  - set:  `export AWS_PROFILE=user2`
  - display: `printenv | grep AWS_PROFILE`
- Windows:
  - set:  `setx AWS_PROFILE user2	`
  - display: `echo %AWS_PROFILE%`

- List current user profile: `aws configure list`
- List all profiles: `aws configure list-profiles`



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

