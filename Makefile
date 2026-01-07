.DEFAULT_GOAL := help

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_\-0-9]+:.*?##/ { printf "  \033[36m%-22s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

app-php8-dev-build: ## Create environment with php8.x for unit tests
	docker compose up -d php8
	docker compose exec php8 composer update

run-tests-php8: app-php8-dev-build ## Runs unit tests with php8.x
	docker compose exec php8 vendor/bin/phpunit --configuration tests/phpunit.xml

app-php7-dev-build: ## Create environment with php7.2 for unit tests
	docker compose up -d php7
	docker compose exec php7 composer update

run-tests-php7: app-php7-dev-build ## Runs unit tests with php8.x
	docker compose exec php7 vendor/bin/phpunit --configuration tests/phpunit.xml

deploy-to-github: ## Creates new release in github from gitlab tags
	sh deploy.sh

create-zip-dev: ## Creates zip file from current local files
	sh create-zip-dev.sh