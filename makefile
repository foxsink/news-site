dev-up:
	docker-compose -f docker-compose.yaml stop
	docker-compose -f docker-compose.yaml build
	docker-compose -f docker-compose.yaml up
dev-sh:
	docker-compose -f docker-compose.yaml exec app /bin/ash
