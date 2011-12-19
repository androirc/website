<?php

namespace Madalynn\AndroBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testArchiveCountPages()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/archives');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(6, $crawler->filter('.paginator a')->count());
    }

    public function testArchiveNumberOfArticle()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/archives');

        $this->assertEquals(5, $crawler->filter('.article')->count());
    }
}