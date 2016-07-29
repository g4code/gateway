TITLE = [gateway]

unit-tests:
	@/bin/echo -e "${TITLE} testing suite started..." \
	&& vendor/bin/phpunit -c tests/unit/phpunit.xml --coverage-html tests/unit/coverage

test: unit-tests

.PHONY: unit-tests, test