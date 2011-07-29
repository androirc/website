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

namespace Madalynn\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Madalynn\UserBundle\Entity\User;

class UserFixtures implements FixtureInterface
{
    public function load($em)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@androirc.com');
        $admin->setPlainPassword('adm456P');

        $admin->setSuperAdmin(true);
        $admin->setEnabled(true);

        $em->persist($admin);
        $em->flush();
    }
}