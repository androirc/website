<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2011 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2011 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MDL\AndroBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

use MDL\AndroBundle\Entity\Donator;

class DonatorFixtures implements FixtureInterface
{
    public function load($em)
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