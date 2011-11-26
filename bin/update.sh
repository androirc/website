#!/bin/bash

echo "assets:install :"
php app/console assets:install --symlink web

echo "assetic:dump :"
php app/console assetic:dump --env=prod --no-debug

echo "clear:cache :"
php app/console clear:cache --env=prod --no-debug
