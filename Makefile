test: install
	php --version
	vendor/bin/kahlan

coverage: install
	mkdir -p coverage
	phpdbg --version
	phpdbg -qrr vendor/bin/kahlan --coverage --istanbul=coverage/coverage.json
	istanbul report

ci: install
	mkdir -p coverage
	phpdbg --version
	phpdbg -qrr vendor/bin/kahlan --coverage --istanbul=coverage/coverage.json --lcov=coverage/coverage.lcov --clover=coverage/coverage.xml

open-coverage:
	open coverage/lcov-report/index.html

integration: install
	test/integration/run

lint: test/bin/php-cs-fixer
	test/bin/php-cs-fixer fix --using-cache no

install:
	composer install

.PHONY: test coverage open-coverage integration lint install

test/bin/php-cs-fixer:
	mkdir -p test/bin
	curl -sSL http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o test/bin/php-cs-fixer
	chmod +x test/bin/php-cs-fixer
