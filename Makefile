run: up composer link migration assets

up:
	docker-compose up -d --build

down:
	docker-compose down

composer:
	docker-compose run --rm app composer install

link:
	docker-compose run --rm app php artisan storage:link

migration:
	docker-compose run --rm app php artisan migrate

assets:
	docker-compose run --rm app npm i
	docker-compose run --rm app npm run build