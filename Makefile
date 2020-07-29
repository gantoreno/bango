start_docker:
	docker-compose -f docker-compose.yml up -d

migrate:
	docker-compose run web php bango migrate
