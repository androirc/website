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

use Madalynn\Bundle\AndroBundle\Entity\Donator;

/**
 * Donator Fixtures
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class DonatorFixtures implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load(ObjectManager $em)
    {
        $martin = new Donator();

        $martin->setName('Martin Pola');
        $martin->setAmount(10);
        $em->persist($martin);

        $jack = new Donator();

        $jack->setName('Jack Wallace');
        $jack->setAmount(2);
        $em->persist($jack);

        $em->flush();
    }
}