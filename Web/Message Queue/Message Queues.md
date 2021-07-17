# Message Queues / Transport





https://aws.amazon.com/de/redis/Redis_Streams_MQ/



**RabbitMQ**

RabbitMQ gives your applications a common platform to send and receive messages, and your messages a safe place to live until received.

**Amazon SQS**

Transmit any volume of data, at any level of throughput, without losing messages or requiring other services to be always available. With SQS, you can  offload the administrative burden of operating and scaling a highly  available messaging cluster, while paying a low price for only what you  use.

- you have to poll queue: Increased poll frequency = increased cost & cpu usage







**ActiveMQ**

Apache ActiveMQ is fast, supports many Cross Language Clients and Protocols,  comes with easy to use Enterprise Integration Patterns and many advanced features while fully supporting JMS 1.1 and J2EE 1.4. Apache ActiveMQ  is released under the Apache 2.0 License.

**ZeroMQ**

The 0MQ lightweight messaging kernel is a library which extends the  standard socket interfaces with features traditionally provided by  specialised messaging middleware products. 0MQ sockets provide an  abstraction of asynchronous message queues, multiple messaging patterns, message filtering (subscriptions), seamless access to multiple  transport protocols and more.

**MQTT**

It was designed as an extremely lightweight publish/subscribe messaging  transport. It is useful for connections with remote locations where a  small code footprint is required and/or network bandwidth is at a  premium.



**Celery**

Celery implements an distributed task queue, optionally using  RabbitMQ as a broker for IPC. Rather than just providing a way of  sending messages between processes, it's providing a system for  distributing actual tasks/jobs between processes. Here's how Celery's  site describes it:

> Task queues are used as a mechanism to distribute work across threads  or machines.
>
> A task queue’s input is a unit of work, called a task, dedicated  worker processes then constantly monitor the queue for new work to  perform.
>
> Celery communicates via messages, usually using a broker to mediate  between clients and workers. To initiate a task a client puts a  message on the queue, the broker then delivers the message to a  worker.
>
> A Celery system can consist of multiple workers and brokers, giving  way to high availability and horizontal scaling.







**Message Transport**

- RabbitMQ
- Redis
- AmazonSQS



**Concurrency**

- Prefork
- Eventlet
- gevent



**Result Stores**

- QMQP, redis
- Apache Cassandra
- IronCache
- Elasticsearch



**Message Queues**

- Celery
- Amazon SQS



- AWS ElastiCache

- Apache Kafka
- RabbitMQ







## Advanced Message Queuing Protocol (AMQP)





****