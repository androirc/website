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

    public function testFirstVisit()
    {
        $session = $this->client->getContainer()->get('session');

        // Clear the session for removing the old requests
        $session->clear();

        $this->assertTrue($session->get('first_visit', true));
        $this->client->request('GET', '/');
        $this->assertFalse($session->get('first_visit'));
    }

    public function testHomepagePage()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertCount(5, $crawler->filter('article'));
    }

    public function testDonatePage()
    {
        $crawler = $this->client->request('GET', '/donate');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertCount(2, $crawler->filter('#content ul > li'));
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

    /**
     * @dataProvider dataMobileHeader
     */
    public function testMobileHeader($host, $hasHeader)
    {
        $this->client->request('GET', $host);
        $this->assertEquals($hasHeader, $this->client->getRequest()->headers->has('X-AndroIRC-Mobile'));
    }

    public function dataMobileHeader()
    {
        return array(
            array('http://www.androirc.com', false),
            array('http://m.androirc.com', true),
            array('http://www.androirc.com/fr/contact', false),
            array('http://m.androirc.com/fr/contact', true),
        );
    }

    /**
     * @dataProvider dataMobileUser
     */
    public function testMobileUser($useragent, $isMobile)
    {
        $this->client->request('GET', '/', array(), array(), array(
            'HTTP_USER_AGENT' => $useragent
        ));

        $this->assertEquals($isMobile, $this->client->getRequest()->getSession()->get('from_mobile'));
    }

    public function dataMobileUser()
    {
        return array(
            array('Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; Nexus One Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', true),
            array('Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.29 Safari/525.13', false),
            array('Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.21 (KHTML, like Gecko) Chrome/19.0.1041.0 Safari/535.21', false),
            array('Opera/9.80 (S60; SymbOS; Opera Mobi/SYB-1107071606; U; en) Presto/2.8.149 Version/11.10', true),
            array('Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)', true),
        );
    }
}
