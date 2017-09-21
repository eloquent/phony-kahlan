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
lint: install
	vendor/bin/php-cs-fixer fix

.PHONY: install
install:
	composer install
