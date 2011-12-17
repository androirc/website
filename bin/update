#!/bin/bash

echo "assets:install :"
php app/console assets:install --symlink web

echo "assetic:dump :"
php app/console assetic:dump --env=prod --no-debug

echo "cache:clear :"
php app/console cache:clear --env=prod --no-debug
