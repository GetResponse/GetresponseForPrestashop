#!/bin/sh

TMP_PATH="`pwd`/tmp"
GITLAB_REMOTE_URL="git@git.int.getresponse.com:integrations/prestashop/getresponse-for-prestashop.git"
GITHUB_REMOTE_URL="git@github.com:GetResponse/GetresponseForPrestashop.git"
GITHUB_PATH="$TMP_PATH/github"
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

echo "--------------------------------------------"
echo "      Gitlab to Github RELEASER      "
echo "--------------------------------------------"
read -p "TAG AND RELEASE VERSION: " VERSION
echo "--------------------------------------------"
echo ""
echo "Before continuing, confirm that:"
echo ""
read -p " - Committed all changes up to Gitlab?"

# validate version in grprestashop.php
PLUGIN_VERSION=`grep '$this->version =' grprestashop.php | awk -F"'" '{print $2}'`
if [ "$VERSION" != "$PLUGIN_VERSION" ]
then
    echo "Version: $VERSION not found in grprestashop.php file"
    exit 1
fi

# validate version in CHANGELOG.md
if ! grep -q "## \[$VERSION\]" CHANGELOG.md; then
    echo "Version: $VERSION not found in CHANGELOG.md file"
    exit 1
fi

# validate version in webservice file
PLUGIN_VERSION=`grep "'plugin_version' => " classes/WebserviceSpecificManagementGetresponseModule.php | awk -F"'" '{print $4}'`
if [ "$VERSION" != "$PLUGIN_VERSION" ]
then
    echo "Version: $VERSION not found in WebserviceSpecificManagementGetresponseModule.php file"
    exit 1
fi

# validate version in config.xml
PLUGIN_VERSION=$(grep '<version>' config.xml | sed -n 's/.*<version><!\[CDATA\[\([^]]*\)\]\]><\/version>.*/\1/p')
echo $PLUGIN_VERSION;
if [ "$VERSION" != "$PLUGIN_VERSION" ]
then
    echo "Version: $VERSION not found in config.xml file"
    exit 1
fi

# validate if tag exists in GitLab
git ls-remote --exit-code --tags origin $VERSION >/dev/null 2>&1
if ! [ $? == 0 ]
then
    echo "Tag $VERSION in GitLab not found"
    exit 1
fi

read -p "PRESS [ENTER] TO BEGIN RELEASING "$VERSION
clear

if ! [ -d "$GITHUB_PATH" ]
then
    echo "Clone Github repository... this may take a while"
    git clone $GITHUB_REMOTE_URL $GITHUB_PATH
fi

echo ""
echo "Copy files"
git fetch --all --tags
git archive --remote="$GITLAB_REMOTE_URL" tags/"$VERSION" | tar -x -C "$GITHUB_PATH"

echo ""
echo "Remove unused files"
for file in ${FILES_TO_DELETE[@]}
do
  rm -rf "$GITHUB_PATH/$file"
done

echo ""
echo ""
echo "----------------"
echo "Github status:"
cd $GITHUB_PATH && git status

echo ""
read -p "Press [ENTER] to commit release $VERSION to Github"

echo ""
echo "Committing to Github... this may take a while"
cd $GITHUB_PATH && git add -A && git commit -a -m "Release $VERSION" && git push || { echo "Unable to commit."; exit 1; }

echo ""
echo "Create new directory for module"
git archive --remote="$GITLAB_REMOTE_URL" tags/"$VERSION" | (cd "$RELEASE_PATH" && tar xf -)

for file in ${FILES_TO_DELETE[@]}
do
  rm -rf "$RELEASE_PATH/$file"
done

echo ""
echo "Build composer"
docker compose exec php71 composer install --no-dev --working-dir="$COMPOSER_REMOTE_PROJECT_PATH"

cp "$RELEASE_PATH/tests/index.php $RELEASE_PATH/vendor/index.php"

echo ""
echo "Create new release"
cd $TMP_PATH && zip -rm "$RELEASE_FILE" "$RELEASE_DIR" -x ".git*"

cd $GITHUB_PATH && gh release create "$VERSION" --generate-notes --latest -n "$VERSION" "$TMP_PATH/$RELEASE_FILE"

echo ""
echo "Remove temporary files"
rm -rf "$TMP_PATH"

echo ""
echo "Release done."