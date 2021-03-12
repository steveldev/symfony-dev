.PHONY: dev

dev:
	make prepare-dev
	make fixtures

prepare-dev:
	php bin/console doctrine:database:drop --if-exists --force --env=dev
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:update --force --env=dev
	
fixtures:
	php bin/console doctrine:fixtures:load -n --env=dev

clear:
	php bin/console c:c --env=dev

