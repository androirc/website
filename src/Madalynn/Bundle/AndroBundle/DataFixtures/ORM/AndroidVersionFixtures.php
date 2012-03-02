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
use Doctrine\Common\DataFixtures\FixtureInterface;

use Madalynn\Bundle\AndroBundle\Entity\AndroidVersion;

/**
 * Version Fixtures
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class VersionFixtures implements FixtureInterface
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
            14 => '4.0'
        );

        foreach ($android as $key => $value) {
            $version = AndroidVersion::create($value);
            $version->setApiLevel($key);

            $em->persist($version);
        }

        $em->flush();
    }
}