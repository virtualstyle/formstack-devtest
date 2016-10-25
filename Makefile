default: help

help:
	@echo "Please use 'make <target>' where <target> is one of"
	@echo "  tests                  Executes the Unit tests"
	@echo "  docs                   Executes PHPDocumentor"
	@echo "  migrate                Executes the Phinx migrate"
	@echo "  rollback               Executes the Phinx rollback"
	@echo "  coverage               Creates the Coverage reports"
	@echo "  cs                     Executes the PHP CS Fixer"
	@echo "  git                    Executes Git add/commit/push"

tests:
	./bin/phpunit;

docs:
	./bin/phpdoc -d ./src -t ./docs;

migrate:
	./bin/phinx migrate -e development && ./bin/phinx seed:run -e development -v;

rollback:
	./bin/phinx rollback -e development -t 0;

coverage:
	./bin/phpunit --coverage-html build/coverage;

cs:
	./bin/php-cs-fixer fix ./src;

gitadd:
	git add .

gitcommit:
	@read -p "Enter Commit Message:" message; \
	git commit -m"$$message";

git push:
	git push -u origin master

.PHONY: tests coverage cs travis-tests docs migrate rollback gitadd gitcommit gitpush