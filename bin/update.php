#!/usr/bin/env php
<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2011 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2011 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Assets management
exec('php app/console assets:install --symlink web');
exec('php app/console assetic:dump --env=prod --no-debug');

// Cache management
exec('php app/console clear:cache --env=prod --no-debug');
