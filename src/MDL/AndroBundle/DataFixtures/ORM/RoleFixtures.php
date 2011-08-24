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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use MDL\AndroBundle\Entity\Role;

class RoleFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load($em)
    {
        $admin = $this->createRole('ROLE_ADMIN', 'The administrator role');

        $em->persist($admin);
        $em->flush();

        $this->addReference('role_admin', $admin);
    }

    public function getOrder()
    {
        return 1;
    }

    private function createRole($name, $desc)
    {
        $role = new Role();

        $role->setRole($name);
        $role->setDescription($desc);

        return $role;
    }
}