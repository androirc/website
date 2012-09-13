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

namespace Madalynn\Bundle\MainBundle;

use Geocoder\Geocoder;

/**
 * Location service
 *
 * @author Julein Brochet <mewt@androirc.com>
 */
class Location
{
    /**
     * @var \Geocoder\Geocoder
     */
    private $geocoder;

    /**
     * Constructor
     *
     * @param Geocoder $geocoder A Geocoder instance
     */
    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * Searchs a location from the user IP
     *
     * @param string $ip The client IP
     *
     * @return string The client country
     */
    public function searchLocation($ip)
    {
        $informations = $this->geocoder->geocode($ip);

        return $informations['country'];
    }
}
