#!/bin/bash

# This script is responsible for making plugin archive file to be installed in the WordPress site.

# 1 - Create temp-plugin directory and copy plugin files
mkdir -p ./temp-plugin

# 2 - Copying necessary files to temp-plugin directory
cp ./composer.json ./temp-plugin/
cp ./composer.lock ./temp-plugin/
cp ./README.md ./temp-plugin/
cp ./wp-dev.php ./temp-plugin/

# 3 - Copying necessary directories to temp-plugin directory
mkdir -p ./temp-plugin/src/ && cp -R ./src/* ./temp-plugin/src/

# 4 - install required composer dependencies
docker run --rm -v "$(pwd)/temp-plugin:/app" composer install
docker run --rm -v "$(pwd)/temp-plugin:/app" composer dump-autoload -o

# 5 - Cleanup
rm -rf ./temp-plugin/composer.json
rm -rf ./temp-plugin/composer.lock

# 6 - Zip the temp-plugin directory
cd ./temp-plugin && zip -r ../wp-dev.zip ./*

# 7 - clean up
cd ../ && rm -rf ./temp-plugin
