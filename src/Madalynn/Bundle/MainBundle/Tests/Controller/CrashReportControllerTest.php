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

class CrashReportControllerTest extends WebTestCase
{
    protected $client;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        // Creation of the kernel
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->client = self::createClient();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getEntityManager()
        ;
    }

    public function testGetRequest()
    {
        $this->client->request('GET', '/crashreport');
        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    public function testMissingArgument()
    {
        $this->client->request('POST', '/crashreport');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testPostRequestWithSdkPhone()
    {
        $this->client->request('POST', '/crashreport', array(
            'callstack' => 'test callstack',
            'phone_model' => 'Android sdk phone',
            'android_version' => '4.0.2',
        ));

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('Coming from a SDK Android phone.', $this->client->getResponse()->getContent());
    }

    public function testPostRequest()
    {
        $this->client->request('POST', '/crashreport', array(
            'callstack' => 'Java callstack',
            'phone_model' => 'Android Test Mobile',
            'android_version' => '4.0.2',
        ));

        $this->assertEquals('ok', $this->client->getResponse()->getContent());
    }

    public function testSamePostRequestTwice()
    {
        $nbr = rand();
        for ($i = 0 ; $i < 5 ; $i++) {
            $this->client->request('POST', '/crashreport', array(
                'callstack' => 'callstack'.$nbr,
                'phone_model' => 'Nexus 4',
                'android_version' => 'AndroidTestVersion'.$nbr,
            ));

            $this->assertEquals('ok', $this->client->getResponse()->getContent());
        }

        $this->em->flush();

        $cr = $this->em->getRepository('MainBundle:CrashReport')
                ->findOneByAndroidVersion('AndroidTestVersion'.$nbr);

        $this->assertFalse($cr->isResolved());
        // $this->assertEquals(5, $cr->getCount());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}
