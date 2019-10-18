.PHONY: lint test

all: lint test
lint: lint.php lint.phpcs lint.openapi
test: test.coverage

test.coverage:
	@phpdbg -qrr vendor/bin/kahlan --istanbul=coverage.json

test.quick:
	@vendor/bin/kahlan


lint.php:
	@php -l config/
	@php -l src/

lint.phpcs:
	@vendor/bin/phpcs --standard=psr2 config src

lint.phpcbf:
	-@vendor/bin/phpcbf --standard=psr2 config src

lint.openapi:
	@docker run --rm -it -v $$(pwd)/docs/openapi:/tmp stoplight/spectral lint "/tmp/ingredients.yaml"
