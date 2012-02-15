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

use Madalynn\Bundle\AndroBundle\Entity\Role;

/**
 * Role Fixtures
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class RoleFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load(ObjectManager $em)
    {
        $admin = $this->createRole('ROLE_ADMIN', 'The administrator role');

        $em->persist($admin);
        $em->flush();

        $this->addReference('role_admin', $admin);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Create a new Role
     *
     * @param type $name The name of the role (e.g. ROLE_SUPER_ADMIN)
     * @param type $desc The description of the role
     *
     * @return Role A new Role instance
     */
    private function createRole($name, $desc)
    {
        $role = new Role();

        $role->setRole($name);
        $role->setDescription($desc);

        return $role;
    }
}