init: docker-up composer-install create-migrations
test: fixtures-tests

docker-up:
	docker compose up -d

composer-install:
	docker compose run --rm php composer install

create-migrations:
	docker compose run --rm php php bin/console doctrine:migrations:migrate --no-interaction || true

fixtures-tests:
	docker compose run --rm php php bin/console --env=test --no-interaction doctrine:database:drop --force
	docker compose run --rm php php bin/console --env=test --no-interaction doctrine:database:create
	docker compose run --rm php php bin/console --env=test --no-interaction doctrine:schema:create
	docker compose run --rm php php bin/console --env=test --no-interaction doctrine:fixtures:load
	docker compose run --rm php ./vendor/bin/phpunit
