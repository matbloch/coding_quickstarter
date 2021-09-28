# DNS





### Hosted Zones

- AWS automatically creates `NS` and `SOA` for each hosted zone
  - `NS`: same name as hosted zone, authorative name servers of the hosted zone
  - `SOA`: start of authority record



## Examples



### Coupling Domain with API Gatway

1. Create named domain for API Gateway

2. Create `A` record with type API Gateway alias and select the endpoint created in 1.)

   example record: 

   ```
   mydomain.com A w89ahaslkdfg.cloudfront.net
   ```

   

**Coupling Subdomain**

- Same as main domain

```
mysubdomain.mydomain.com A w89ahaslkdfg.cloudfront.net
```

