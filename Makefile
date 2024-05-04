run: up composer link assets storage

up:
	docker-compose up -d --build

down:
	docker-compose down

composer:
	docker-compose run --rm app composer install

link:
	docker-compose run --rm app php artisan storage:link

assets:
	docker-compose run --rm app npm i
	docker-compose run --rm app npm run build

storage:
	sudo chmod -R 777 /storage