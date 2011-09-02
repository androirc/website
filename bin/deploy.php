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

$server = array(
    'user' => 'web',
    'host' => 'bender.madalynn.eu',
    'port' => 2222,
    'dir'  => '/home/androirc.com/beta/'
);

$path = __DIR__ . '/../app/config';
$options = '-azC --force --delete --progress';

$informations = array(
    'ssh'   => sprintf('"ssh -p%s"', $server['port']),
    'login' => sprintf('%s@%s:%s', $server['user'], $server['host'], $server['dir'])
);

if (file_exists($path . '/rsync_exclude.txt')) {
    $options .= sprintf(' --exclude-from=%s/rsync_exclude.txt', $path);
}

if (file_exists($path . '/rsync_include.txt')) {
    $options .= sprintf(' --include-from=%s/rsync_include.txt', $path);
}

if (file_exists($path . '/rsync.txt')) {
    $options .= sprintf(' --files-from=%s/rsync.txt', $path);
}

$command = sprintf('rsync %s -e %s ../ %s',
        $options,
        $informations['ssh'],
        $informations['login']
);

exec($command);