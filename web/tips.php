<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2012 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2012 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$lang = get('lang', 'en');
$date = get('date');

$url = 'http://www.androirc.com/tip/' . $lang;

if ($date) {
    $url .= '/' . $date;
}

header('Status: 301 Moved Permanently', false, 301);
header('Location: ' . $url);

function get($name, $default = null)
{
    return isset($_GET[$name]) ? $_GET[$name] : $default;
}