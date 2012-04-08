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
    public function testArchiveCountPages()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/archives');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(4, $crawler->filter('.paginator a')->count());
    }

    public function testArchiveNumberOfArticle()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/archives');

        $this->assertEquals(10, $crawler->filter('article')->count());
    }
}