default: help

help:
	@echo "Please use 'make <target>' where <target> is one of"
	@echo "  test                   Rollback, Migrate, and Tests"
	@echo "                                                "
	@echo "  all                    As above, but also build PHPDocs and"
	@echo "                         PHPUnit Coverage report"
	@echo "                                                "
	@echo "  doc                    Build PHPDocs and PHPUnit coverage report"
	@echo "                                                "
	@echo "  cs                     Executes the PHP CS Fixer on src and tests"
	@echo "                                                "
	@echo "  tests                  Executes the Unit tests"
	@echo "  docs                   Executes PHPDocumentor"
	@echo "  migrate                Executes the Phinx migrate"
	@echo "  rollback               Executes the Phinx rollback"
	@echo "  coverage               Creates the Coverage reports"
	@echo "  cssrc                  Executes the PHP CS Fixer on src folder"
	@echo "  csstests               Executes the PHP CS Fixer on tests folder"
	@echo "  gitadd                 Executes Git add"
	@echo "  gitcommit              Executes Git commit"
	@echo "  gitpush                Executes Git push"
	@echo "  php-xml                Enables php-xml extension for PHPUnit"
	@echo "  log-init               Initializes default log directories"

tests:
	./bin/phpunit;

docs:
	./bin/phpdoc -d ./src -t ./build/docs;

migrate:
	./bin/phinx migrate -e development && ./bin/phinx seed:run -e development -v;

rollback:
	./bin/phinx rollback -e development -t 0 -f;

coverage:
	./bin/phpunit --coverage-html build/coverage;
	sudo -s \
	find ./build/coverage -type f -exec chown www-data:www-data {} \;
	sudo -s \
	find ./build/coverage -type f -exec chmod 664 {} \;

cssrc:
	./bin/php-cs-fixer fix ./src;
	./bin/php-cs-fixer fix ./index.php;

cstests:
	./bin/php-cs-fixer fix ./tests;

gitadd:
	git add .;

gitcommit:
	@read -p "Enter Commit Message:" message; \
	git commit -m"$$message";

gitpush:
	git push -u origin master;

php-xml:
	sudo apt-get install php-xml;

log-init:
	sudo rm -rf ./tmp/log &&\
	sudo mkdir -p ./tmp/log &&\
	sudo touch ./tmp/log/dev.log &&\
	sudo find ./tmp -type d -exec chmod 775 {} \;
	sudo find ./tmp -type f -exec chmod 664 {} \;
	exit;

test :
	$(build)

cv :
	$(buildcoverage)

doc :
	$(builddoc)

cs :
	$(buildcs)

define build
make rollback
make migrate
make tests
endef

define buildcoverage
make rollback
make migrate
make coverage
endef

define builddoc
make coverage
make docs
endef

define buildcs
make cssrc
make cstests
endef

.PHONY: tests coverage cs travis-tests docs migrate rollback gitadd gitcommit gitpush
