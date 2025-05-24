install: build composer octane link migration assets optimize

deploy: pull composer migration assets optimize horizon

run: build optimize

down:
	docker-compose run --rm app php artisan horizon:terminate
	docker-compose down

build:
	docker-compose up -d --build

composer:
	docker-compose run --rm app composer install --no-dev

octane:
	docker-compose run --rm app composer require laravel/octane spiral/roadrunner-cli spiral/roadrunner-http predis/predis

link:
	docker-compose run --rm app php artisan storage:link

migration:
	docker-compose run --rm app php artisan migrate --force

assets:
	docker-compose run --rm app npm i
	docker-compose run --rm app npm run build

optimize:
	docker-compose run --rm app php artisan optimize
	docker-compose run --rm app php artisan config:cache

pull:
	git reset --hard
	git pull

horizon:
	docker-compose run --rm app php artisan horizon:terminate