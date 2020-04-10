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





## Data Modeling





## Table Definition

- `TableName` 

  - The name of the table

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
    "KeySchema": [{"KeyType": "HASH", "AttributeName": "Id"}],
    "AttributeDefinitions": [
        {"AttributeName": "Deleted", "AttributeType": "S"},
        {"AttributeName": "Id", "AttributeType": "S"},
    ]
}
```



**Example:** Creating a table in BOTO3













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





## Local Development

https://github.com/aws-samples/aws-sam-java-rest



