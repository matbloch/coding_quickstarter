# Deploying FLASK Applications





**GUnicorn**

- spawns synchronous workers which are bound to processes by default

  > The default synchronous 
  > workers assume that your application is resource-bound in terms of CPU 
  > and network bandwidth. Generally this means that your application 
  > shouldn’t do anything that takes an undefined amount of time. An example
  > of something that takes an undefined amount of time is a request to the
  > internet. At some point the external network will fail in such a way 
  > that clients will pile up on your servers. So, in this sense, any web 
  > application which makes outgoing requests to APIs will benefit from an 
  > asynchronous worker.



- Redis

  > Redis is an advanced key-value store. It is often referred to as a data structure server since keys can contain strings, hashes, lists, sets and sorted sets. Can also be used as a message broker.

- RabbitMQ

  > RabbitMQ gives your applications a common platform to send and receive 
  > messages, and your messages a safe place to live until received.

- Celery

> 1. Celery client: 
>    - This will be connect your Flask application to the Celery task. The client will issue the commands for the task.
> 2. Celery worker: 
>    - A process that runs a background task.
> 3. Message broker: 
>    - The Celery client communicates to the Celery worker through a  message broker, such as  Redis, RabbitMQ or  RQ.

- Gunicorn

  > [**Gunicorn**](http://docs.gunicorn.org/en/stable/)**:** It is a Python [Web Server Gateway Interface](https://en.wikipedia.org/wiki/Web_Server_Gateway_Interface) (WSGI) HTTP server. Since Python is not multithreaded, we try to create multiple gunicorn 
  > workers which are individual processes that have their own memory 
  > allocations to compensate the parallelism for handling requests.

**Flask**

- ​	single threaded

## Libararies



### Celery





### Redis





## Identifying Bottlenecks



**CPU bound workload**

- When we have CPU bound workload, thread based approaches (such as 
  greenlets) are not going to work because there is nobody to delegate the
  work for. What handles the client, also handles the computation and it 
  is fundamentally wrong.





## Use Case Examples

**Case Studies**

- [Long Computations over REST](https://medium.com/@grzegorzolechwierowicz/long-computations-over-rest-http-in-python-4569b1187e80)
- [Asynchronous Tasks with Flask and Redis Queue](https://testdriven.io/blog/asynchronous-tasks-with-flask-and-redis-queue/)

- [Redis and polling](https://realpython.com/flask-by-example-integrating-flask-and-angularjs/)
- [Example Redis queue with task status polling](https://testdriven.io/blog/asynchronous-tasks-with-flask-and-redis-queue/)





**Network bound Webapps**

- [NginX, gunicorn, flask](https://medium.com/@maheshkkumar/a-guide-to-deploying-machine-deep-learning-model-s-in-production-e497fd4b734a)
  - common state?
  - when to scale?



**CPU bound Webapps**

- [Flask-SocketIO, Celery](https://github.com/poonesh/Flask-SocketIO-Celery-example)
- [Flask, Redis, Celery on Docker](https://nickjanetakis.com/blog/dockerize-a-flask-celery-and-redis-application-with-docker-compose)

