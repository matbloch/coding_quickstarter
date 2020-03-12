# Amazon ECR (Elastic Container Registry)

> **NOTE:** See also ECR [User Guide](https://docs.aws.amazon.com/AmazonECR/latest/userguide/ECR_AWSCLI.html#AWSCLI_push_image)



## Getting Started

**0. Building the Docker Image**

- `docker build . -t my-test-image`

**1. Creating a Repository**

- **Option A:** https://console.aws.amazon.com/ecr/home

  - "Get Started"
  - "Repository Configuration"

- **Option B:** AWS CLI

  - Create the repository:

     `aws ecr create-repository --repository-name my-test-image`

**2. Authenticate With Repository**

- Retrieve the Docker login command to authenticate Docker client with container registry:
  - CLI V1: `aws ecr get-login --region us-east-2 --no-include-email`
  - CLI V2:
    - `aws ecr get-login-password`
    - `docker login -u AWS -p <password> -e none https://<aws_account_id>.dkr.ecr.<region>.amazonaws.com`
- Post the command

**3. Pushing the Docker Image to ECR**

- Authenticate with repository (see 2.)

- Tag the repository

  `docker tag my-test-image:latest ACCT_ID.dkr.ecr.us-east-2.amazonaws.com/my-test-image:latest` (where ACCT_ID is your own AWS account ID)

- Push the image to ECR

  `docker push ACCT_ID.dkr.ecr.us-east-2.amazonaws.com/my-test-image:latest` (again, using your own AWS account ID in place of ACCT_ID)

**4. Pull Image**

- Authenticate with repository (see 2.)
- `docker pull ACCT_ID.dkr.ecr.us-east-2.amazonaws.com/my-test-image:latest`

**5. Delete Image**

- `aws ecr batch-delete-image --repository-name my-test-image --image-ids imageTag=the-image-tag-you-want-to-delete`





## Managing Repositories through the AWS Console

1. Open the Amazon Container Service (ACS)
2. Select the Amazon Container Registry (ACR)
3. Create a new registry
4. Select "View push commands" for how to push Docker images to the registry



