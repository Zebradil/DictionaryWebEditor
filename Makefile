init-database:
	docker-compose -f docker/db.yml up -d
	until PGPASSWORD=nopass pg_isready -h localhost -d dictor -U postgres; do sleep 3; done
	./bin/console doctrine:database:create
	./bin/console doctrine:schema:create

eradicate-database:
	docker-compose -f docker/db.yml down
	rm -rf docker/dbdata/*

server-start:
	./bin/console server:start

load-fixtures:
	./bin/console doctrine:fixtures:load --purge-with-truncate -n

server-stop:
	docker-compose -f docker/db.yml down
	./bin/console server:stop
