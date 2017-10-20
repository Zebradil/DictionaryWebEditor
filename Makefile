server-start:
	docker-compose -f docker/db.yml up -d
	./bin/console server:start

server-stop:
	docker-compose -f docker/db.yml down
	./bin/console server:stop
