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

    public function testCustomHeader()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->headers->has('X-AndroIRC'));
    }

    public function testMobileHeader()
    {
        $client = self::createClient();
        $useragents = array(
            array('Mozilla/5.0 (Linux; U; Android 2.2; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', true),
            array('Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; HTC Desire 1.19.161.5 Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', true),
            array('Mozilla/5.0 (Windows; U; Windows NT 6.1; fr; rv:1.9.2) Gecko/20100115 Firefox/3.6', false),
            array('Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.186 Safari/535.1', false),
            array('Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/5.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; OfficeLiveConnector.1.5; OfficeLivePatch.1.3; .NET4.0C)', false)
        );

        foreach ($useragents as $useragent) {
            $client->request('GET', '/', array(), array(), array(
                'HTTP_USER_AGENT' => $useragent[0]
            ));

            //$this->assertEquals($useragent[1], $client->getRequest()->headers->has('X-AndroIRC-Mobile'));
        }
    }
}