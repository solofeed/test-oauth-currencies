build:
	docker-compose build && docker-compose exec fpm composer install

start:
	docker-compose up -d
