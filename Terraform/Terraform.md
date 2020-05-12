# Terraform





`terraform init`

`terraform plan`

`terraform apply`

`terraform apply -auto-approve`

`terraform refresh` visualize outputs



**Must read**

- https://blog.gruntwork.io/how-to-manage-terraform-state-28f5697e68fa#7077
- https://www.terraform.io/docs/cloud/workspaces/repo-structure.html
- https://github.com/hashicorp/terraform/issues/18632





## Key Concepts

### Configuration Files

> **NOTE:** Terraform loads all files ending in `.tf` in a directory.



**Code Structure**

- `main.tf` - call modules, locals and data-sources to create all resources
- `variables.tf` - contains declarations of variables used in `main.tf`
- `outputs.tf` - contains outputs from the resources created in `main.tf`

`terraform.tfvars` should not be used anywhere except [composition]().









## Providers





### Docker

**Windows**

```json
# Configure the Docker provider
provider "docker" {
  version = "~> 2.7"
  # NOTE: on other platforms use e.g. "tcp://localhost:2376".
  #       The Docker daemon uses TLS which requires certificates to be installed.
  host    = "npipe:////.//pipe//docker_engine"
}
```



### AWS



## Workspaces







## Filesystem Functions



- `templatefile`
  - used to generate code from contents of a file





## Scripting





**for_each**

```json
resource "aws_subnet" "example" {
  # local.network_subnets is a list, so we must now project it into a map
  # where each key is unique. We'll combine the network and subnet keys to
  # produce a single unique key per instance.
  for_each = {
    for subnet in local.network_subnets : 
    	"${subnet.network_key}.${subnet.subnet_key}" => subnet
  }
  vpc_id            = each.value.network_id
  availability_zone = each.value.subnet_key
  cidr_block        = each.value_cidr_block
}
```



## Local Values

**Definition**

```
locals {
  service_name = "forum"
  owner        = "Community Team"
}
```

**Usage**

```
locals {
  # Common tags to be assigned to all resources
  common_tags = {
    Service = local.service_name
    Owner   = local.owner
  }
}
```



## Input Variables









**Definition**

```json
variable "image_id" {
  type = string
}

variable "availability_zone_names" {
  type    = list(string)
  default = ["us-west-1a"]
}

variable "docker_ports" {
  type = list(object({
    internal = number
    external = number
    protocol = string
  }))
  default = [
    {
      internal = 8300
      external = 8300
      protocol = "tcp"
    }
  ]
}
```

**Access**

- `var.<NAME>`

```json
resource "aws_instance" "example" {
  instance_type = "t2.micro"
  ami           = var.image_id
}
```





### Variable Types

See https://learn.hashicorp.com/terraform/getting-started/variables





### Assigning Variables

#### From the CLI

```bash
terraform apply -var 'region=us-east-1'
```

#### From File

```json
region = "us-east-1"
```

**Loading Order**

Terraform loads variables in the following order, with later sources taking precedence over earlier ones:

- Environment variables
- The `terraform.tfvars` file, if present.
- The `terraform.tfvars.json` file, if present.
- Any `*.auto.tfvars` or `*.auto.tfvars.json` files, processed in lexical order of their filenames.
- Any `-var` and `-var-file` options on the command line, in the order they are provided. (This includes variables set by a Terraform Cloud workspace.)





## Examples

- configuration structures: https://www.reddit.com/r/devops/comments/53sijz/how_do_you_structure_terraform_configurations/

- small AWS project: https://github.com/antonbabenko/terraform-best-practices/tree/master/examples/small-terraform
- https://github.com/terraform-aws-modules/terraform-aws-atlantis

- AWS task definition from json template: https://stackoverflow.com/questions/54944626/how-to-avoid-duplication-in-terraform-when-having-multiple-services-in-ecs-which
- structuring aws architecture in modules https://aws.amazon.com/de/blogs/apn/terraform-beyond-the-basics-with-aws/