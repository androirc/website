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

namespace Madalynn\Bundle\MainBundle\Tests;

require_once __DIR__.'/../../../../../app/AppKernel.php';

class AndroircVersionTest extends \PHPUnit\Framework\TestCase
{
    protected $container;

    public function setUp()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    public function testLocalhostLocation()
    {
        $location = $this->container->get('androirc.location');

        $this->assertEquals('localhost', $location->searchLocation('127.0.0.1'));
    }

    /**
     * @dataProvider dataRealIpLocation
     */
    public function testRealIpLocation($country, $ip)
    {
        $location = $this->container->get('androirc.location');

        $this->assertEquals($country, $location->searchLocation($ip));
    }

    public function dataRealIpLocation()
    {
        return array(
            array('France', '91.121.158.197'),
            array('United States', '73.194.67.94'),
        );
    }
}
