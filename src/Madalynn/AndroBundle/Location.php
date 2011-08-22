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

namespace Madalynn\AndroBundle;

use Buzz\Browser;

class Location
{
    private $ip;
    private $location;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getLocation()
    {
        if ($this->location) {
            return $this->location;
        }

        $browser = new Browser();
        $this->location = $browser->get('http://geoip.wtanaka.com/cc/' . $this->ip)->getContent();

        return $this->location;
    }
}