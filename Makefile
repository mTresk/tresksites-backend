run: up composer link migration assets optimize

up:
	docker-compose up -d --build

down:
	docker-compose down

composer:
	docker-compose run --rm app composer install
	docker-compose run --rm app composer require laravel/octane spiral/roadrunner-cli spiral/roadrunner-http predis/predis

link:
	docker-compose run --rm app php artisan storage:link

migration:
	docker-compose run --rm app php artisan migrate

assets:
	docker-compose run --rm app npm i
	docker-compose run --rm app npm run build

optimize:
	docker-compose run --rm app php artisan optimize
	docker-compose run --rm app php artisan config:cache