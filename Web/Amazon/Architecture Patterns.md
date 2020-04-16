# Architecture Patterns

https://containersonaws.com

#### Public Service, Public Network

- A public facing endpoint designed to receive push notifications
- An edge service which needs to make outbound connections to other services on the internet

![public-subnet-public-lb](D:/dev/coding_quickstarter/Web/Amazon/img/public-subnet-public-lb.png)

#### Public Service, Private Network

- A service which is public facing but needs an extra layer of security  hardening by not even having a public IP address that an attacker could  send a request directly to.
- A service which initiates outbound connections but to the public you  want those connections to **originate from a specific and limited set of  IP addresses** that can be whitelisted

![private-subnet-public-lb](D:/dev/coding_quickstarter/Web/Amazon/img/private-subnet-public-lb.png)

