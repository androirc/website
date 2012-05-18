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

namespace Madalynn\Bundle\AndroBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Madalynn\Bundle\AndroBundle\Entity\AndroidVersion;
use Madalynn\Bundle\AndroBundle\Entity\AndroircVersion;

/**
 * Version Fixtures
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class VersionFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load(ObjectManager $em)
    {
        $android = array(
            1 => '1.0',
            2 => '1.1',
            3 => '1.5',
            4 => '1.6',
            5 => '2.0',
            6 => '2.0.1',
            7 => '2.1',
            8 => '2.2',
            9 => '2.3',
            11 => '3.0',
            12 => '3.1',
            13 => '3.2',
            14 => '4.0',
            15 => '4.0.3'
        );

        $androirc = array(
            // 1.x versions
            1 => '1.0',
            2 => '1.0.1',
            3 => '1.0.2',
            4 => '1.0.3',
            5 => '1.0.4',
            6 => '1.1',
            7 => '1.1.1',
            9 => '1.1.2',
            11 => '1.1.3',
            12 => '1.2',
            13 => '1.2.1',
            14 => '1.2.2',
            15 => '1.2.3',
            16 => '1.2.4',
            17 => '1.2.5',
            18 => '1.2.6',
            19 => '1.3',
            20 => '1.3.1',
            21 => '1.3.2',
            22 => '1.3.3',
            23 => '1.3.4',
            // 2.x versions
            25 => '2.0',
            26 => '2.0.1',
            28 => '2.0.2',
            29 => '2.0.3',
            30 => '2.0.4',
            31 => '2.0.5',
            32 => '2.0.6',
            33 => '2.0.7',
            34 => '2.1',
            35 => '2.1.1',
            36 => '2.1.2',
            // 3.x versions
            42 => '3.0',
            47 => '3.0.1',
            48 => '3.0.2',
            49 => '3.0.3',
            50 => '3.0.4',
            53 => '3.1',
            54 => '3.2',
            55 => '3.2.1'
        );

        foreach ($android as $key => $value) {
            $version = AndroidVersion::create($value);
            $version->setApiLevel($key);

            $em->persist($version);
            $this->addReference('android_version_'.$version, $version);
        }

        foreach ($androirc as $key => $value) {
            $version = AndroircVersion::create($value);
            $version->setCode($key);

            $em->persist($version);
            $this->addReference('androirc_version_'.$version, $version);
        }

        $em->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}
