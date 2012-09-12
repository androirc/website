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

namespace Madalynn\Bundle\AdminBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    /**
     * @dataProvider dataAdminHomepageNeedLogin
     */
    public function testAdminHomepageNeedLogin($url)
    {
        $this->client->request('GET', $url);
        $response = $this->client->getResponse();

        $this->assertTrue($response->isRedirection());
        $this->assertRegExp('/login/', $response->getTargetUrl());

        $this->client->followRedirect();
        $response = $this->client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertRegExp('/You need to signin to see this page/', $response->getContent());
    }

    public function dataAdminHomepageNeedLogin()
    {
        return array(
            array('/admin/'),
            array('/fr/admin/'),
            array('/fi/admin/'),
            array('/es/admin/'),
            array('/admin/beta'),
            array('/fr/admin/beta'),
            array('/fr/admin/beta/new'),
        );
    }

    public function testIdentification()
    {
        $this->client->request('GET', '/admin/');

        $crawler  = $this->client->followRedirect();
        $response = $this->client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertRegExp('/You need to signin to see this page/', $response->getContent());

        $form = $crawler->selectButton('_submit')->form();
        $crawler = $this->client->submit($form, array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));

        $this->client->followRedirect();
        $response = $this->client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertRegExp('/Welcome to the administration center/', $response->getContent());
    }
}
