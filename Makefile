.PHONY: test
test: install
	php --version
	vendor/bin/kahlan

.PHONY: coverage
coverage: install
	mkdir -p coverage
	phpdbg --version
	phpdbg -qrr vendor/bin/kahlan --coverage --istanbul=coverage/coverage.json
	istanbul report

.PHONY: ci
ci: install
	mkdir -p coverage
	phpdbg --version
	phpdbg -qrr vendor/bin/kahlan --coverage --istanbul=coverage/coverage.json --lcov=coverage/coverage.lcov --clover=coverage/coverage.xml

.PHONY: open-coverage
open-coverage:
	open coverage/lcov-report/index.html

.PHONY: integration
integration: install
	test/integration/run

.PHONY: lint
lint: test/bin/php-cs-fixer
	test/bin/php-cs-fixer fix --using-cache no

.PHONY: install
install:
	composer install

test/bin/php-cs-fixer:
	mkdir -p test/bin
	curl -sSL http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o test/bin/php-cs-fixer
	chmod +x test/bin/php-cs-fixer
