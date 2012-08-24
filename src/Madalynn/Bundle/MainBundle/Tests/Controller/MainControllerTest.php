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

namespace Madalynn\Bundle\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }


    /**
     * @dataProvider dataCustomAndroircHeader
     */
    public function testCustomAndroircHeader($url)
    {
        $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->headers->has('X-AndroIRC'));
    }

    public function dataCustomAndroircHeader()
    {
        return array(
            array('www.androirc.com'),
            array('m.androirc.com'),
            array('m.androirc.com/contact'),
            array('www.androirc.com/fr/contact'),
            array('www.androirc.com/contact'),
            array('m.androirc.com/fr'),
        );
    }
}
