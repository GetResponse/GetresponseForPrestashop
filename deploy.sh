#!/bin/sh

TMP_PATH="`pwd`/tmp"
GIT_PATH=`pwd`
GITLAB_REMOTE_URL="git@git.int.getresponse.com:integrations/prestashop/getresponse-for-prestashop.git"
GITHUB_REMOTE_URL="git@github.com:GetResponse/GetresponseForPrestashop.git"
GITHUB_PATH="$TMP_PATH/github"
RELEASE_PATH="$TMP_PATH/release"
RELEASE_FILE="grprestashop.zip"

FILES_TO_DELETE=(
  "$GITHUB_PATH/.php_cs.dist"
  "$GITHUB_PATH/deploy.sh"
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
echo "Before continuing, confirm that you have done the following :)"
echo ""
read -p " - Added a changelog for "$VERSION" to CHANGELOG.md file?"
read -p " - Set version in the main file to "$VERSION"?"
read -p " - Set version in the Webservice configuration file to "$VERSION"?"
read -p " - Set stable tag in the config.xml file to "$VERSION"?"
read -p " - Committed all changes up to Gitlab?"

echo ""
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
  rm -rf $file
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
cd $GITHUB_PATH && git commit -a -m "Release $VERSION" && git push || { echo "Unable to commit."; exit 1; }

echo ""
echo "Create new directory for module"
git archive --remote="$GITLAB_REMOTE_URL" tags/"$VERSION" | (cd "$RELEASE_PATH" && tar xf -)

echo ""
echo "Build composer"
composer install --no-dev --working-dir="$RELEASE_PATH"

echo ""
echo "Create new release"
cd $RELEASE_PATH && zip -rm "$RELEASE_FILE" . -x ".git*"
cd $GITHUB_PATH && gh release create "$VERSION" --generate-notes --latest -n "$VERSION" "$RELEASE_PATH/$RELEASE_FILE"

echo ""
echo "Remove temporary files"
rm -rf "$TMP_PATH"

echo ""
echo "Release done."