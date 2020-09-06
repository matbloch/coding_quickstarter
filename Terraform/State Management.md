# State Management





## Open Questions

- different environments in different folders vs shared folder (see multiple workspaces state storage)
- how to migrate Infrastructure to different terraform template without loosing the state
- how to migrate from local to remote backend
- how to structure AWS IAM for different environments
- how to apply terraform changes only to certain resources, e.g. `ec2.tf`

> There's a [`target`](https://www.terraform.io/docs/commands/plan.html#target-resource) parameter that will let you specify just one piece. You should run it via `plan` so you can see what you're getting into, like:
>
> ```
> terraform plan -out=vpc.plan -target=module.vpc
> # you should see the plan details for only the VPC creation
> # to apply it to your infrastructure:
> terraform apply vpc.plan
> ```
>
> You can `target` multiple things, so if you want your storage and instances at the same time you can do `-target=module.storage -target=module.instance` both at the same time.





## Remote Backends: S3

- Supports Locking through DynamoDB





## Workspaces

- separate state

https://learn.hashicorp.com/terraform/modules/tf-code-management

**Creating Workspaces**

- `terraform workspace new dev`
- `terraform workspace new prod`

State storage for multiple workspaces

```shell-session
├── terraform.tfstate.d
│   ├── dev
│   │   └── terraform.tfstate
│   ├── prod
│   │   └── terraform.tfstate
```

**Selecting a workspace**

- `terraform workspace list`
- `terraform workspace select dev`

**Apply/Destroy**

- `terraform apply -var-file=dev.tfvars`
- `terraform destroy -var-file=dev.tfvars`





### Using Workspaces

- `${terraform.workspace}`



**Variable Definitions per Environment**

```yaml
variable "token" {
  type = "map"
  default = {
    production = "abc123"
    development = "123abc"
  }
}
```

**Variable Lookup**

```yaml
provider "github" {
  token = "${lookup(var.token, terraform_workspace)}"
}
```

**Conditioning**

```yaml
resource "aws_instance" "example" {
  count = "${terraform.workspace == "default" ? 5 : 1}"
}
```

**Tagging**

```yaml
resource "aws_instance" "example" {
  tags = {
    Name = "web - ${terraform.workspace}"
  }
}
```





