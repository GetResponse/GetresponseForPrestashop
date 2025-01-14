#!/bin/sh

TMP_PATH="`pwd`/tmp"
PROJECT_DIR="`pwd`"
RELEASE_DIR="grprestashop"
RELEASE_PATH="$TMP_PATH/$RELEASE_DIR"
RELEASE_FILE="grprestashop.zip"
COMPOSER_REMOTE_PROJECT_PATH="/plugin/tmp/$RELEASE_DIR"

FILES_TO_DELETE=(
  ".idea"
  ".git"
  ".DS_Store"
  ".php_cs.dist"
  ".php_cs.cache"
  ".php-cs-fixer.cache"
  ".php-cs-fixer.dist.php"
  "captainhook.json"
  "deploy.sh"
  "create-zip-dev.sh"
  ".gitlab-ci.yml"
  "Dockerfile"
  "docker-compose.yaml"
  "Makefile"
  ".env"
  "tests"
  "vendor"
  "tmp"
)

if [ -d "$TMP_PATH" ]
then
  rm -rf $TMP_PATH
fi

mkdir -p $TMP_PATH
mkdir -p $RELEASE_PATH

echo ""
echo "Copy files"
rsync -av . "$RELEASE_PATH" --exclude TMP_PATH

echo ""
echo "Remove unused files"
for file in ${FILES_TO_DELETE[@]}
do
  rm -rf "$RELEASE_PATH/$file"
done

echo ""
echo "Build composer"
if ! docker compose ps | grep -q "php71"; then
  echo "Container php71 is not running. Starting it..."
  docker compose up -d php71
fi
docker compose exec php71 composer install --no-dev --working-dir="$COMPOSER_REMOTE_PROJECT_PATH"

echo ""
echo "Create new zip"
cd $TMP_PATH && zip -rm "$RELEASE_FILE" "$RELEASE_DIR" -x ".git*"

echo "Created zip file: $TMP_PATH/$RELEASE_FILE"
echo "ZIP done."