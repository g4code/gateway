TITLE = [gateway]

unit-tests:
	@/bin/echo -e "${TITLE} testing suite started..." \
	&& XDEBUG_MODE=coverage vendor/bin/phpunit -c tests/unit/phpunit.xml --coverage-html tests/unit/coverage

test: unit-tests

.PHONY: unit-tests, test