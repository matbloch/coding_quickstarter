# JSON Web Tokens


**JWT consists of:**
- Header
	- type of token (JWT)
	- hashing algorithm (e.g. HS256, RS256)
- Payload
- Signature
	- signed (with secret) encoded header and payload

#### Signing Algorithms


##### Symmetric vs. Asymmetric Encryption


##### HS256

Hash-based Message Authentication Code (HMAC) is an algorithm that combines a certain payload with a secret using a cryptographic hash function like **SHA-256**. The result is a code that can be used to verify a message only if both the generating and verifying parties know the secret. In other words, HMACs allow messages to be verified through shared secrets.

**Important**
- JWT payload is not encrypted, it is just signed
- Anyone can extract the payload without any private or public keys.
- Adding sensitive data like passwords, social security numbers in JWT payload is not safe if you are going to send them in a non-secure connection.

##### RS256
- public-key algorithm
- you deal with a public/private key pair rather than a shared secret

##### ES256

