```bash
> composer create-project robiningelbrecht/symfony-skeleton [app-name] --no-install --ignore-platform-reqs
```

Open `.env` and set following ENV VARIABLES:

```
DOCKER_CONTAINER_BASE_NAME=skeleton
DOCKER_MYSQL_PORT=3306
DOCKER_NGINX_PORT=8081
```

If this a CLI-only application, remove references to PHP-FPM and Nginx:

* docker/php-fpm
* docker/nginx
* remove services `php-fpm` & `nginx` from `docker-composer.yml`

Update the database name of your application:

* docker/mysql
* .env DATABASE_URL

If you don't need database functionality you can remove these references:

* docker/mysql
* .env DATABASE_URL
* remove service `mysql` from `docker-composer.yml`
* `make composer arg="remove doctrine/orm"`
* `make composer arg="remove adrenalinkin/doctrine-naming-strategy"`

```bash
# Build docker containers
> make build-containers
# Install dependencies
> make composer arg="install"
```