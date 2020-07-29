all: start

start:
	docker-compose -f docker-compose.yml up -d

stop:
	docker-compose down

migrate:
	docker-compose run web php bango migrate
