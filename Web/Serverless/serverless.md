# Serverless



## Basics



- **Functions**: AWS lambda function
- **Events**: Anything that triggers an AWS Lambda Function. Examples:
  - A CloudWatch timer (e.g. run every 5min)
  - CloudWatch alert
  - AWS bucket upload
  - AWS API Gateway HTTP endpoint request
- **Resources**: AWS infrastructure component
- **Services**: unit of organisation



## Actions



**Deployment**

```bash
serverless deploy --verbose
```

Deploy to specific stage

```bash
serverless deploy --stage production
```

**Behind the curtains**

...



## Stages

**Specifying the stage**

a. `serverless.yml`

- use the `dev` attribute

````yaml
service: service-name

provider:
  name: aws
  stage: dev
````

b. CLI

- use the `--stage` parameter

```bash
serverless deploy --stage dev
```



**Staging variables inside configuration**

- pick `stage` from the `--stage` argument, else, use default set on `provider`

```yaml
custom:
  myStage: ${opt:stage, self:provider.stage}
provider:
  name: aws
  stage: dev
```