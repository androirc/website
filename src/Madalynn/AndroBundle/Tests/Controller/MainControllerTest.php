<?php

namespace Madalynn\AndroBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(5, $crawler->filter('.article')->count());
    }

    public function testDonate()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/donate');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(2, $crawler->filter('#content ul > li')->count());
    }
}