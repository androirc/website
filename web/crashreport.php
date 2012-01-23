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

$vars = array(
    'phone_model', 'android_version',
    'thread_name', 'error_message',
    'callstack', 'version'
);

$posts = array();
foreach ($vars as $var) {
    if (isset($_POST[$var])) {
        $posts[$var] = $_POST[$var];
    }
}

$c = curl_init();

curl_setopt($c, CURLOPT_URL, 'http://www.androirc.com/crashreport');
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_POSTFIELDS, $posts);

// Let's go!
curl_exec ($c);

curl_close ($c);