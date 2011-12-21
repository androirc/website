<?php

namespace Madalynn\Bundle\AndroBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TipControllerTest extends WebTestCase
{
    public function testTipAction()
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/tip/fr');
        $this->assertNotEquals('', $client->getResponse()->getContent());

        $crawler = $client->request('GET', '/tip/es');
        $this->assertEquals('No tips to display', $client->getResponse()->getContent());

        $crawler = $client->request('GET', '/tip/en/2011-12-25');
        $this->assertEquals('We wish you a merry christmas... *sings*', $client->getResponse()->getContent());
    }
}