init-database:
	docker-compose -f docker/db/db.yml up -d
	until PGPASSWORD=nopass pg_isready -h localhost -p 5433 -d dictor -U postgres; do sleep 3; done
	./bin/console doctrine:database:create
	./bin/console doctrine:schema:create

eradicate-database:
	docker-compose -f docker/db/db.yml down
	rm -rf docker/db/dbdata/*

server-start:
	./bin/console server:start

load-fixtures:
	./bin/console doctrine:fixtures:load --purge-with-truncate -n

server-stop:
	./bin/console server:stop
