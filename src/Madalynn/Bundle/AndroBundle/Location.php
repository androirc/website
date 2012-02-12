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

namespace Madalynn\Bundle\AndroBundle;

use Buzz\Browser;

class Location
{
    private $buzz;

    public function __construct(Browser $buzz)
    {
        $this->buzz = $buzz;
    }

    public function searchLocation($ip)
    {
        return $this->buzz->get('http://geoip.wtanaka.com/cc/'.$ip)
                          ->getContent();
    }
}