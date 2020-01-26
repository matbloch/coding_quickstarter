# Deploying Docker on AWS





You **do not** need to have all containers in the same task definition. From the [docs](https://docs.aws.amazon.com/AmazonECS/latest/developerguide/task_definitions.html):

> **Your entire application stack does not need to exist on a single task  definition**, and in most cases it should not. Your application can span  multiple task definitions by combining related containers into their  own task definitions, each representing a single component.

Also, note that you are limited to 10 container definitions in a  single task definition and it's perfectly fine to use just one container definition in each of your task definitions.

As for scaling, you can create a service for each task definition.  This allows logically separate components in your stack to scale  independently. For example, if you have 2 services, one for back-end api service and another for front-end nginx, you can create 2 separate task definitions for them, each service scaling independently.

**Possible reasons to group your container definitions into a single task definition:**

- They have a single logical purpose or share a lifecycle (started and terminated together).
- You want to scale them together.
- You want the containers to share resources like data volumes.
- The containers need to run on the same host instance and do things like communicate over localhost.

On the other hand, if the containers perform separate logical  functions, scale independently, don't share a lifecycle or resources  like volumes, you are probably better off using multiple task  definitions/services.

There is also some documentation on application architecture for ECS [here](https://docs.aws.amazon.com/AmazonECS/latest/developerguide/application_architecture.html) which explains this further.