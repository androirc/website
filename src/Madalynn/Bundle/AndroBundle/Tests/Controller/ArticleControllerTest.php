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

class ArticleControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    public function testNumberOfPages()
    {
        $crawler = $this->client->request('GET', '/archives');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertCount(4, $crawler->filter('.paginator a'));
    }

    public function testNumberOfArticlesPerPage()
    {
        $crawler = $this->client->request('GET', '/archives');
        $this->assertCount(10, $crawler->filter('article'));
    }
}