docker-up:
	docker-compose up -d
docker-down:
	docker-compose down
docker-restart:
	docker-compose down && docker-compose up -d
docker-build:
	docker-compose build
docker-rebuild:
	docker-compose down && docker-compose up -d --build

bash:
	docker-compose exec merchants-app bash
db:
	docker-compose exec merchants-db bash

models:
	php artisan ide-helper:models -W

swagger-generate:
	php artisan l5-swagger:generate
