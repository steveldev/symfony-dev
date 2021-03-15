.PHONY: dev

dev:
	make prepare-dev
	make fixtures-dev

prepare-dev:
	php bin/console doctrine:database:drop --if-exists --force --env=dev
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:update --force --env=dev
	
fixtures-dev:
	php bin/console doctrine:fixtures:load -n --env=dev

clear-cache:
	php bin/console c:c --env=dev


.PHONY: tests
tests:
	make prepare-test
	make fixtures-test
	make coverage

prepare-test:
	php bin/console doctrine:database:drop --if-exists --force --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update --force --env=test
	
fixtures-test:
	php bin/console doctrine:fixtures:load -n --env=test

coverage: 
	php bin/phpunit --coverage-html ./coverage

clear:
	php bin/console c:c --env=test


.PHONY: analyze
analyze : 
	make analyze-dev
analyze-dev:
	./vendor/bin/phpcs -p src
	./vendor/bin/phpcbf -p src
	.vendor/bin/phpstan src

.PHONY: install
install:
	composer install