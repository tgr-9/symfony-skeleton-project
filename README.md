<h1 align="center">Symfony Skeleton</h1>

<p align="center">
<a href="https://github.com/robiningelbrecht/symfony-skeleton/actions/workflows/ci.yml"><img src="https://github.com/robiningelbrecht/symfony-skeleton/actions/workflows/ci.yml/badge.svg" alt="CI"></a>
<a href="https://github.com/robiningelbrecht/symfony-skeleton/blob/master/LICENSE"><img src="https://img.shields.io/github/license/robiningelbrecht/symfony-skeleton?color=428f7e&logo=open%20source%20initiative&logoColor=white" alt="License"></a>
<a href="https://phpstan.org/"><img src="https://img.shields.io/badge/PHPStan-level%2010-succes.svg?logo=php&logoColor=white&color=31C652" alt="PHPStan Enabled"></a>
<a href="https://php.net/"><img src="https://img.shields.io/packagist/php-v/robiningelbrecht/symfony-skeleton?color=%23777bb3&logo=php&logoColor=white" alt="PHP"></a>
<a href="https://phpunit.de/"><img src="https://img.shields.io/packagist/dependency-v/robiningelbrecht/symfony-skeleton/phpunit/phpunit.svg?logo=php&logoColor=white" alt="PHPUnit"></a>
</p>

---

## Bootstrap new project

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
# Setup project (configure containers and functionality)
> make console arg="app:setup"
```

```bash
# Build docker containers
> make build-containers
```

## Rate Limiter

```php
    #[RateLimiter('anonymous')]
    #[Route(path: '/your/important/route', methods: ['GET', 'POST'])]
    public function handle(Request $request): Response
    {
      // ...
    }
```