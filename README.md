```bash
> composer create-project robiningelbrecht/symfony-skeleton [app-name] --no-install --ignore-platform-reqs
```

Open `.env` and set following ENV VARIABLES:

```
DOCKER_CONTAINER_BASE_NAME=skeleton
DOCKER_NGINX_PORT=8081
```

If this a CLI-only application, remove references to PHP-FPM and Nginx:

* docker/php-fpm
* docker/nginx
* remove services `php-fpm` & `nginx` from `docker-composer.yml`


```bash
# Build docker containers
> make build-containers
# Install dependencies
> make composer arg="install"
```