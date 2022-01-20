help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

release: ## Create module archive for release
	mkdir release
	git archive -o ./release/getresponse.zip --prefix=getresponse/ HEAD
	cd ./release && unzip getresponse.zip
	rm ./release/getresponse.zip
	rm -rf ./release/getresponse/tests
	rm -rf ./release/getresponse/config.xml
	rm -rf ./release/getresponse/release.sh
	rm -rf ./release/getresponse/.gitlab-ci.yml
	rm -rf ./release/getresponse/Makefile
	cd ./release/getresponse && composer install --no-dev
	cd ./release && git clone git@github.com:dg/php54-arrays.git && cd php54-arrays && php convert.php --reverse ../getresponse
	cd ./release && git clone git@github.com:jmcollin/autoindex.git && cd autoindex && php index.php ../getresponse
	cd ./release && zip -r ../getresponse.zip getresponse
	rm -rf release

run-fixers: ## Runs fixers
	composer require --dev "prestashop/php-dev-tools:3.*" "phpstan/phpstan:^0.12"
	composer run-fixers