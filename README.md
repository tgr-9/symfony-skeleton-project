```bash
> composer create-project robiningelbrecht/symfony-skeleton [app-name] --no-install --ignore-platform-reqs
# Build docker containers
> docker-compose up -d --build
# Install dependencies
> docker-compose run --rm php-cli composer install
```