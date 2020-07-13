翻譯自 https://codefresh.io/containers/docker-anti-patterns/

Container usage is exploding. Even if you are not yet convinced that Kubernetes is the way forward, it is very easy to add value just by using Docker on its own. Containers can now simplify both deployments and CI/CD pipelines.

The official Docker best practices page is highly technical and focuses more on the structure of the Dockerfile instead of generic information on how to use containers in general. Every Docker newcomer will at some point understand the usage of Docker layers, how they are cached, and how to create small Docker images. Multi-stage builds are not rocket science either. The syntax of Dockerfiles is fairly easy to understand.

However, the main problem of container usage is the inability of companies to look at the bigger picture and especially the immutable character of containers/images. Several companies in particular attempt to convert their existing VM-based processes to containers with dubious results. There is a wealth of information on low-level details of containers (how to create them and run them), but very little information on high level best practices.

To close this documentation gap, I present to you a list of high-level Docker best-practices. Since it is impossible to cover the internal processes of every company out there I will instead explain bad practices (i.e. what you should not do). Hopefully, this will give you some insights on how you should use containers.

Here is the complete list of bad practices that we will examine:

1. Attempting to use VM practices on containers.
2. Creating Docker files that are not transparent.
3. Creating Dockerfiles that have side effects.
4. Confusing images used for deployment with those used for development.
5. Building different images per environment.
6. Pulling code from git into production servers and building images on the fly.
7. Promoting git hashes between teams.
8. Hardcoding secrets into container images.
9. Using Docker as poor man’s CI/CD.
10. Assuming that containers are a dumb packaging method.
