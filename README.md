```bash
> composer create-project robiningelbrecht/symfony-skeleton [app-name] --no-install --ignore-platform-reqs
```

Open `.env` and set following ENV VARIABLES:

```
DOCKER_CONTAINER_BASE_NAME=skeleton
DOCKER_MYSQL_PORT=3306
DOCKER_NGINX_PORT=8081
```

```bash
# Install dependencies
> make composer arg="install"
# Setup project
make console arg="app:setup"
```

```bash
# Build docker containers
> make build-containers
```