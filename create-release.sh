#!/bin/bash

# Create a proper WordPress plugin ZIP for release
# Run this before creating a GitHub release

VERSION=$1

if [ -z "$VERSION" ]; then
    echo "Usage: ./create-release.sh 1.0.2"
    exit 1
fi

echo "Creating release package for version $VERSION..."

# Create temp directory
TEMP_DIR="/tmp/gm-dev-tools-release"
rm -rf $TEMP_DIR
mkdir -p $TEMP_DIR/gm-dev-tools

# Copy files (excluding git, docs, etc)
rsync -av --exclude='.git' \
          --exclude='.github' \
          --exclude='*.md' \
          --exclude='.gitignore' \
          --exclude='.DS_Store' \
          --exclude='create-release.sh' \
          --exclude='*.zip' \
          ./ $TEMP_DIR/gm-dev-tools/

# Create the ZIP with correct structure
cd $TEMP_DIR
zip -r gm-dev-tools.zip gm-dev-tools

# Move to current directory
mv gm-dev-tools.zip ../

cd ..
rm -rf $TEMP_DIR

echo "✅ Created gm-dev-tools.zip"
echo ""
echo "Next steps:"
echo "1. git add ."
echo "2. git commit -m 'Release version $VERSION'"
echo "3. git tag $VERSION"
echo "4. git push && git push --tags"
echo "5. Go to GitHub and create release"
echo "6. Upload gm-dev-tools.zip to the release"
echo ""
echo "The download link will be:"
echo "https://github.com/grainandmortar/gm-dev-tools/releases/download/$VERSION/gm-dev-tools.zip"
echo ""
echo "This ZIP works directly in WordPress - no renaming!"