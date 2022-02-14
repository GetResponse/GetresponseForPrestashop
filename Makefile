help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

app-php56-dev-build: ## Create environment with php5.6 for unit tests
	docker build --target php5 -t prestashop-php5-cli .
	docker run -d --name prestashop-php5-cli -v $PWD:/plugin prestashop-php5-cli
	docker cp prestashop-php5-cli:/plugin/vendor vendor

app-php71-dev-build: ## Create environment with php7.1 for unit tests
	docker build --target php7 -t prestashop-php7-cli .
	docker run -d --name prestashop-php7-cli -v $PWD:/plugin prestashop-php7-cli
	docker cp prestashop-php7-cli:/plugin/vendor vendor

release: ## Create module archive for release
	mkdir release
	git archive -o ./release/grprestashop.zip --prefix=grprestashop/ HEAD
	cd ./release && unzip grprestashop.zip
	rm ./release/grprestashop.zip
	rm -rf ./release/grprestashop/tests
	rm -rf ./release/grprestashop/.gitlab-ci.yml
	rm -rf ./release/grprestashop/Makefile
	rm -rf ./release/grprestashop/Dockerfile
	cd ./release/grprestashop && composer install --no-dev
	cd ./release && git clone git@github.com:dg/php54-arrays.git && cd php54-arrays && php convert.php --reverse ../grprestashop
	cd ./release && git clone git@github.com:jmcollin/autoindex.git && cd autoindex && php index.php ../grprestashop
	cd ./release && zip -r ../grprestashop.zip grprestashop
	rm -rf release

run-fixers: ## Runs fixers
	composer require --dev "prestashop/php-dev-tools:3.*" "phpstan/phpstan:^0.12"
	composer run-fixers
