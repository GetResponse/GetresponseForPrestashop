#!/bin/sh

TMP_PATH="`pwd`/tmp"
RELEASE_DIR="grprestashop"
RELEASE_PATH="$TMP_PATH/$RELEASE_DIR"
RELEASE_FILE="grprestashop.zip"

FILES_TO_DELETE=(
  ".php_cs.dist"
  "deploy.sh"
  "create_zip_from_current_files.sh"
  ".gitlab-ci.yml"
  "Dockerfile"
  "Makefile"
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
cp -R * "$RELEASE_PATH"

echo ""
echo "Remove unused files"
for file in ${FILES_TO_DELETE[@]}
do
  rm -rf "$RELEASE_PATH/$file"
done

echo ""
echo "Build composer"
composer install --no-dev --working-dir="$RELEASE_PATH"

echo ""
echo "Create new zip"
cd $TMP_PATH && zip -rm "$RELEASE_FILE" "$RELEASE_DIR" -x ".git*"

echo "ZIP done."