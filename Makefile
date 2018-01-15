init-database:
	docker-compose -f docker/db.yml up -d
	./bin/console doctrine:database:create
	./bin/console doctrine:schema:create

server-start:
	./bin/console server:start

load-fixtures:
	./bin/console doctrine:fixtures:load --purge-with-truncate -n

server-stop:
	docker-compose -f docker/db.yml down
	./bin/console server:stop
