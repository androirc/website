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

class QuickStartControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    public function testDefaultOptions()
    {
        $this->client->request('GET', '/quickstart/1');

        $this->assertRegExp('/Welcome/', $this->client->getResponse()->getContent());
        $this->assertNotRegExp('/background-color: #424242;/', $this->client->getResponse()->getContent()); // Not black theme
    }

    public function testLanguage()
    {
        $this->client->request('GET', '/quickstart/1/en');
        $this->assertRegExp('/Welcome/', $this->client->getResponse()->getContent());

        $this->client->request('GET', '/quickstart/1/fr');
        $this->assertRegExp('/Bienvenue/', $this->client->getResponse()->getContent());
    }

    public function testTheme()
    {
        $this->client->request('GET', '/quickstart/1/en/light');
        $this->assertNotRegExp('/background-color: #424242;/', $this->client->getResponse()->getContent());

        $this->client->request('GET', '/quickstart/1/en/dark');
        $this->assertRegExp('/background-color: #424242;/', $this->client->getResponse()->getContent());
    }
}
