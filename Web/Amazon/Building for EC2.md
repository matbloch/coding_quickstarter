# Building for EC2



https://cloudacademy.com/blog/aws-ec2-instance-types-explained/



See article about A1 ARM:

https://blog.boltops.com/2018/12/16/ec2-a1-instance-with-aws-homegrown-arm-processor-easy-way-to-save-40



## EC2 A1

- Powered by AWS Graviton processors, based on ARM architecture



## AWS CodePipeline

- 1$/month
- free for 30 days after creation



## AWS CodeBuild

https://docs.aws.amazon.com/codebuild/latest/userguide/create-project.html



1. Prerequisites: Setup an AWS ECR Repository
2. Head to [CodeBuild](https://us-east-2.console.aws.amazon.com/codesuite/codebuild/), start new project





Build phases are configured in yaml file:

**buildspec.yml**

```yaml
version: 0.2

phases:
  install:
    runtime-versions:
      docker: 18
  pre_build:
    commands:
      - echo Logging in to Amazon ECR...
      - $(aws ecr get-login --no-include-email --region $AWS_DEFAULT_REGION)
  build:
    commands:
      - echo Build started on `date`
      - echo Building the Docker image...          
      - docker build -t $IMAGE_REPO_NAME:$IMAGE_TAG .
      - docker tag $IMAGE_REPO_NAME:$IMAGE_TAG $AWS_ACCOUNT_ID.dkr.ecr.$AWS_DEFAULT_REGION.amazonaws.com/$IMAGE_REPO_NAME:$IMAGE_TAG      
  post_build:
    commands:
      - echo Build completed on `date`
      - echo Pushing the Docker image...
      - docker push $AWS_ACCOUNT_ID.dkr.ecr.$AWS_DEFAULT_REGION.amazonaws.com/$IMAGE_REPO_NAME:$IMAGE_TAG
```





**Amazon Images**

https://docs.aws.amazon.com/codebuild/latest/userguide/build-env-ref-available.html

**Build Environment Compute Types**

https://docs.aws.amazon.com/codebuild/latest/userguide/build-env-ref-compute-types.html

- ARM: build.general1.large