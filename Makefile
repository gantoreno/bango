all: start

start:
	docker-compose -f docker-compose.yml up -d

build:
	docker-compose -f docker-compose.yml up --build -d

stop:
	docker-compose stop

remove:
	docker-compose down

migrate:
	docker-compose run web php bango migrate
