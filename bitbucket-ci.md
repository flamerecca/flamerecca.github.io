# 用 bitbucket 做 CI

目前我的機制：

```yml
image: php:7.2

pipelines:
    default:
    - step:
          caches:
          - composer
          name: code style check
          script:
          - apt-get update && apt-get install -y unzip
          - curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
          - composer self-update
          - composer install -n --prefer-dist
          - ./vendor/bin/phpcs --standard=psr2 app
          artifacts:
          - vendor/**
    - step:
          caches:
          - composer
          name: phpunit test
          script:
          - cp .env.example .env
          - php artisan key:generate
          - ./vendor/bin/phpunit
definitions:
    caches:
        composer: ~/.vendor
```

裡面用 artifacts 將第一階段的 vendor 資料夾備份到下一階段，以免每個階段都要做一次 composer install
