dev-build:
	docker-compose -f docker-compose.yaml -f docker/compose-cfg/dev.yaml build

dev-up:
	docker-compose -f docker-compose.yaml -f docker/compose-cfg/dev.yaml stop
	docker-compose -f docker-compose.yaml -f docker/compose-cfg/dev.yaml up
dev-sh:
	docker-compose -f docker-compose.yaml -f docker/compose-cfg/dev.yaml exec app /bin/ash
dev-init:
	docker-compose -f docker-compose.yaml -f docker/compose-cfg/dev.yaml exec app /src/app/bin/console doctrine:fixtures:load --group=initAdmin

