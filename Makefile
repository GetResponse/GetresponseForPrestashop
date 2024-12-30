.DEFAULT_GOAL := help

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_\-0-9]+:.*?##/ { printf "  \033[36m%-22s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

app-php72-dev-build: ## Create environment with php7.1 for unit tests
	docker compose up -d php72
	docker compose exec php72 composer update

run-tests-php72: app-php72-dev-build ## Runs unit tests with php7.1
	docker compose exec php72 vendor/bin/phpunit --configuration tests/phpunit.xml

deploy-to-github: ## Creates new release in github from gitlab tags
	sh deploy.sh

create-zip-dev: ## Creates zip file from current local files
	sh create-zip-dev.sh