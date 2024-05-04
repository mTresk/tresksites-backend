run: up composer link assets storage

up:
	sudo docker compose up -d --build

down:
	sudo docker compose down

composer:
	sudo docker compose run --rm app composer install

link:
	sudo docker compose run --rm app php artisan storage:link

assets:
	sudo docker compose run --rm app npm i
	sudo docker compose run --rm app npm run build

storage:
	sudo chmod -R 777 /storage