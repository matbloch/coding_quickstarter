# Boto3





- https://realpython.com/python-boto3-aws-s3/





## Setup



- Go to IAM in the AWS console
- Create a new user, e.g. `boto3user`
  - select `Programmatic access`
  - Add the `AmazonS3FullAccess ` policy

```python
import boto3
s3_resource = boto3.resource('s3')

```



## Configuring Credentials

Boto can be configured in multiple ways. Regardless of the source or sources that you choose, you **must** have AWS credentials and a region set in order to make requests.



1. Passing credentials as parameters in the `boto.client()` method
2. Passing credentials as parameters when creating a `Session` object
3. Environment variables
4. Shared credential file (`~/.aws/credentials`)
5. AWS config file (`~/.aws/config`)
6. Assume Role provider
7. Boto2 config file (`/etc/boto.cfg` and `~/.boto`)
8. Instance metadata service on an Amazon EC2 instance that has an IAM role configured.



## CloudWatch

https://boto3.amazonaws.com/v1/documentation/api/latest/guide/cw-examples.html



```python
import boto3

cloudwatch = boto3.resource('cloudwatch')
metric = cloudwatch.Metric('namespace','name')
```

```python
response = metric.put_data()
```







### Metrics

- see [the Docs](https://boto3.amazonaws.com/v1/documentation/api/latest/reference/services/cloudwatch.html#CloudWatch.Client.put_metric_data) for more parameters (e.g. statistics, multiple values etc)

```python
import boto3
cloudwatch = boto3.client('cloudwatch')
```

```python
response = cloudwatch.put_metric_data(
    MetricData = [
        {
            'MetricName': 'KPIs',
            'Dimensions': [
                {
                    'Name': 'PURCHASES_SERVICE',
                    'Value': 'CoolService'
                },
                {
                    'Name': 'APP_VERSION',
                    'Value': '1.0'
                },
            ],
            'Unit': 'None',
            'Value': random.randint(1, 500)
        },
    ],
    Namespace='CoolApp'
)
```









## S3 Buckets

### Basic Operations



**Upload**

```python
import boto3
s3 = boto3.resource('s3')
bucket = s3.Bucket('mybucket')

with open('filename', 'rb') as data:
    bucket.upload_fileobj(
        Filename=data,  # path to file
        Key='mykey'     # identifier
    )
```







**Download**

```python
s3_resource.Object(first_bucket_name, first_file_name).download_file(
    f'/tmp/{first_file_name}')
```

```python
def download_from_s3(self, s3_file):
    """
        Download a file from the S3 output bucket to your hard drive.
        """
    destination_path = os.path.join(
        self.converted_directory,
        os.path.basename(s3_file)
    )
    body = self.out_bucket.Object(s3_file).get()['Body']
    with open(destination_path, 'wb') as dest:
        # Here we write the file in chunks to prevent
        # loading everything into memory at once.
        for chunk in iter(lambda: body.read(4096), b''):
        dest.write(chunk)

        print("Downloaded {0}".format(destination_path))
```



**Load file in-memory**

```python
s3 = boto3.resource('s3')
bucket = s3.Bucket('test-bucket')
# Iterates through all the objects, doing the pagination for you. Each obj
# is an ObjectSummary, so it doesn't contain the body. You'll need to call
# get to get the whole body.
for obj in bucket.objects.all():
    key = obj.key
    body = obj.get()['Body'].read()
```



**Copying between buckets**

```python
def copy_to_bucket(bucket_from_name, bucket_to_name, file_name):
    copy_source = {
        'Bucket': bucket_from_name,
        'Key': file_name
    }
    s3_resource.Object(bucket_to_name, file_name).copy(copy_source)

copy_to_bucket(first_bucket_name, second_bucket_name, first_file_name)
```



### Object Metadata







### Performance Considerations

- Performance issues when files are named similarly
- **Solution:** Randomize file names

```python
random_file_name = ''.join([str(uuid.uuid4().hex[:6]), file_name])
```



