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

exec('mkdir -p app/cache');
exec('mkdir -p app/logs');

exec('chmod 777 app/cache');
exec('chmod 777 app/logs');

exec('php app/console assets:install --symlink web');