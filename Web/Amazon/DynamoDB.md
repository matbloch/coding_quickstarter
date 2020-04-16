# DynamoDB on AWS

> **DynamoDB** is a fully managed NoSQL key/value and document database.
>
> Tables consist of **Items** (rows) and Items consist of **Attributes** (columns)
>



https://aws.amazon.com/de/dynamodb/?c=db&sec=srv

https://www.dynamodbguide.com/anatomy-of-an-item#attributes





## Key Concepts



### Primary Key Types

- **simple primary key**: Similar to key-value stores
- **composite primary key**: 
  - partition key: Additional grouping
  - sort key: For sorting items with the same partition
  - **Example**: Customer orders. Partition key would be CustomerId and sort key would be OrderID



### Secondary Indexes







## Attribute Types

### Basic Types

- **String**: `S`
  - `"Name": { "S": "Alex DeBrie" }`
- **Number**: `N`
  - `"Age": { "N": "29" }`
  - `"Value": {"N": "1.231"}`
- **Bytes**: `B` 
  - e.g. base64 encoded file
  - `"SecretMessage": { "B": "bXkgc3VwZXIgc2VjcmV0IHRleHQh" }`
- **Bool**: `BOOL`
  - `"IsActive": { "BOOL": "false" }`

- (**Null type**: `NULL`)
  - `"OrderId": { "NULL": "true" }`

### Collections

> DynamoDB "Expressions" allow to directly operate on individual collection items



- **List**: `L`

  - `"Roles": { "L": [ "Admin", "User" ] }`

- **Map**: `M`

  -  ```
    "FamilyMembers": 
        "M": {
            "Bill Murray": {
                "Relationship": "Spouse",
                "Age": 65
            },
            "Tina Turner": {
                "Relationship": "Daughter",
                "Age": 78,
                "Occupation": "Singer"
            }
        }
    }
     ```

- **String Set**: `SS`
  - unique set of strings
  - `"Roles": { "SS": [ "Admin", "User" ] }`

- **Number Set**: `NS`
  - unique set of numbers
  - `"RelatedUsers": { "NS": [ "123", "456", "789" ] }`

- **Binary Set**: `BS`

  - unique set of strings

  - ```none
    "SecretCodes": { "BS": [ 
    	"c2VjcmV0IG1lc3NhZ2UgMQ==", 
    	"YW5vdGhlciBzZWNyZXQ=", 
    	"dGhpcmQgc2VjcmV0" 
    ] }
    ```



## Expressions

> Expressions are logical comparators used in queries

https://www.dynamodbguide.com/expression-basics

### Formulating the Query / Expression

> Defines the query. **Values to substitute** are passed through expression-attribute-values.

- Defined through `key-condition-expression` (CLI or argument, depending on framework)

**Chaining Conditions**

- `AND`
- `OR`

**Functions**

- `attribute_exists()`
- `attribute_not_exists()`
- `attribute_type()`
- `begins_with()`
- `contains()` 
  - check if **string** contains a particular **substring**
  - check if **set** contains a particular **element**
- `size()`

**Examples**

- `"attribute_not_exists(DateShipped)"`
- `"begins_with(StateCityPostcode, :statecitypostcode)"`



### Substituting Attribute Values

> Explicit values for a query must be passed separately and types have to be annotated

- Defined through `expression-attribute-values` (CLI or argument, depending on framework)

- attribute names must start with `:`



**Examples**

- `{":agelimit": {"N": 21} }`



### Example Queries

**Query by partition key**

```
--key-condition-expression "Username = :username"
```

```
--expression-attribute-values '{
        ":username": { "S": "daffyduck" }
    }
```



### Expression Placeholders

> DynamoDB has reserved names. Define placeholders for expressions to avoid clashes.



```
 --expression-attribute-names '{
    "#a": "Age"
  }'
```



### 







## Data Modeling / Table Design











## Table Definition

- `TableName` 

  - The name of the table

- `ProvisionedThroughput`

  - Represents the provisioned throughput settings for a specified table or index
  - If you set BillingMode as `PROVISIONED` , you must specify this property. If you set BillingMode as `PAY_PER_REQUEST` , you cannot specify this property.

- `KeySchema` 

  - Specifies the attributes that make up the primary key

  - Used attributes must be defined in `AttributeDefinitions`

  - Each `KeySchemaElement` in the array is composed of:

    - `AttributeName` - The name of this key attribute.

    - `KeyType ` 

      > DynamoDB stores items with same partition key physically close together, in sorted order by the sort key value

      - `HASH`  known as partition key
      - `RANGE` known as sort key

- `AttributeDefinitions` 
  - An array of attributes that describe the key schema for the table and indexes.



**Example:** JSON table definition

```json
{
    "TableName": "Items",
    "ProvisionedThroughput": {"WriteCapacityUnits": 5, "ReadCapacityUnits": 5},
    "KeySchema": [{"KeyType": "HASH", "AttributeName": "Id"}],
    "AttributeDefinitions": [
        {"AttributeName": "Deleted", "AttributeType": "S"},
        {"AttributeName": "Id", "AttributeType": "S"},
    ]
}
```



**Example:** Create a table with the AWS CLI

> **NOTE:** We use the profile "testing" here

```bash
aws --profile=testing dynamodb create-table --cli-input-json file://Items.json
```



**Example:** Creating a table in BOTO3





## Identity and Access Management



https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/authentication-and-access-control.html







## Boto3 Integration

### Insert

- `client.put_item`

```python
client = boto3.client('dynamodb', endpoint_url='http://localhost:8000')
```

```python
range_key = "{state}#{city}#{postcode}".format(
    state=row['State/Province'].upper(),
    city=row['City'].upper(),
    postcode=row['Postcode'].upper()
)
client.put_item(
    TableName="StarbucksLocations",
    Item={
        "Country": {"S": row.get('Country') or 'NULL' },
        "StateCityPostcode": {"S": range_key },
    },
)
```





### Get

- `client.get_item`

```python
client = boto3.client('dynamodb', endpoint_url='http://localhost:8000')
```

```python
def get_store_location(store_number):
    print("Attempting to retrieve store number {}...\n".format(store_number))
    try:
        resp = client.get_item(
            TableName="StarbucksLocations",
            Key={
                "StoreNumber": {"S": store_number}
            }
        )
        print("Store number found! Here's your store:\n")
        pprint.pprint(resp.get('Item'))
    except Exception as e:
        print("Error getting item:")
        print(e)
```



### Query

```python
resp = client.query(
    TableName="StarbucksLocations",
    IndexName='StoreLocationIndex',
    KeyConditionExpression=key_condition_expression,
    ExpressionAttributeValues=expression_values
)
```



### Expression Queries







## AWS CLI



https://docs.aws.amazon.com/cli/latest/userguide/cli-services-dynamodb.html







**Conditional Insert**

```
$ aws dynamodb put-item \
    --table-name UsersTable \
    --item '{
      "Username": {"S": "yosemitesam"},
      "Name": {"S": "Yosemite Sam"},
      "Age": {"N": "73"}
    }' \
    --condition-expression "attribute_not_exists(#u)" \
    --expression-attribute-names '{
      "#u": "Username"
    }' \
    $LOCAL
```





## Local Development



### CLI Configuration for Testing

**Testing Credentials**

> The down-loadable DynamoDB requires **any** password. For testing you should use fake credentials. 

```
AWS Access Key ID: "fakeMyKeyId"
AWS Secret Access Key: "fakeSecretAccessKey"
```

**Custom Testing Profile**

- Open `~/.aws/config` and add a new profile `testing`
- **Alternative:** Use the AWS CLI
  - `aws configure --profile testing`

```ini
[default]
region = us-east-1 # Or your preferred default region

[profile testing]
aws_access_key_id = AnyKeyID
aws_secret_access_key = AnySecretAccessKey
```

**Using Custom Profiles in the CLI**

- use `--profile=testing` to select a specific profile when using the `aws` cli

Example:

```bash
aws --profile=testing dynamodb describe-table --table-name=MyTable
```







### Examples



**Example:** Table Creation from CLI

```bash
aws dynamodb create-table \
  --table-name TableName  \
  --attribute-definitions \
    AttributeName=id,AttributeType=S --key-schema \
    AttributeName=id,KeyType=HASH \
  --provisioned-throughput ReadCapacityUnits=2,WriteCapacityUnits=2 \
  --endpoint-url http://localhost:8000
```



**Example:** Loading a database definition on startup

```
version: '2'
services:
    dynamodb:
        container_name: dynamodb
        image: amazon/dynamodb-local:latest
        entrypoint: java
        command: "-jar DynamoDBLocal.jar -sharedDb -dbPath /data"
        restart: always
        volumes:
          - dynamodb-data:/data
        ports:
          - "8000:8000"
 
volumes:
    dynamodb-data:
        external: true
```

