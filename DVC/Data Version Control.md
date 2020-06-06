# Data Version Control



### Install

`pip install dvc`





### Setting up a Remote Storage on S3

- `dvc remote add -d myremote s3://mybucket/myproject`

- `git add .dvc/config`



**Granting access to S3 bucket to multiple users**

- create custom policy to grant access
- create new role and attach policy
- assign role to users

https://stackoverflow.com/questions/47355444/aws-s3-setting-a-bucket-policy-for-multiple-users-in-an-account

**Creating multiple profiles for AWS CLI**

https://docs.aws.amazon.com/cli/latest/userguide/cli-chap-configure.html#cli-multiple-profiles



### Getting Started

**Initialize DVC**

- `dvc init` will add a new `.dvc/`
- `git commit -m "init DVC" `

**Track Data**

- `dvc add datadir` Track directory

- `git add .gitignore datadir.dvc` commit the tracking and add the folder to gitignore

- `git commit -m "Add raw data"`

**Push Data**

- `dvc push`

**Pull Data**

- `dvc pull`