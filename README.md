# CarGoRoad

## How To Run The First Time
1. Make sure you have docker & docker compose
2. Run
```
docker run --rm \
    --pull=always \
    -v "$(pwd)":/opt \
    -w /opt -u 1000\
    laravelsail/php82-composer:latest \
    composer install

```

or simply `composer install` if you have `composer` installed globally
3. Copy `.env.example` to `.env`: `cp .env.example .env`
4. Run the containers: `./vendor/bin/sail up`
5. Migrate & seed using `./vendor/bin/sail artisan migrate:fresh --seed`
6. Run test using `./vendor/bin/sail artisan test`

## How To Run The Nth Time
`./vendor/bin/sail up`

## How To Stop
`./vendor/bin/sail down`
