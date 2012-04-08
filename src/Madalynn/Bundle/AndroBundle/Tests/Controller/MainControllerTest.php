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

namespace Madalynn\Bundle\AndroBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(5, $crawler->filter('article')->count());
    }

    public function testDonate()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/donate');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(2, $crawler->filter('#content ul > li')->count());
    }

    public function testCustomHeader()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->headers->has('X-AndroIRC'));
    }

    public function testMobileHeader()
    {
        $client = self::createClient();

        foreach (array('m' => true, 'www' => false) as $key => $value) {
            $client->request('GET', sprintf('http://%s.androirc.com/', $key));
            $this->assertEquals($value, $client->getRequest()->headers->has('X-AndroIRC-Mobile'));
        }
    }
}