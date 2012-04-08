<?php

namespace Madalynn\Bundle\AndroBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CrashReportControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    public function testGetRequest()
    {
        $this->client->request('GET', '/crashreport');
        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }
}