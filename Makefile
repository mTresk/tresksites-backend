run: up composer link

up:
	docker-compose up -d --build

down:
	docker-compose down

composer:
	docker-compose run --rm app composer install

link:
	docker-compose run --rm app php artisan storage:link