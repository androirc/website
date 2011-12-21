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

namespace Madalynn\Bundle\AndroBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Madalynn\Bundle\AndroBundle\Entity\User;

/**
 * User Fixtures
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class UserFixtures extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load($em)
    {
        $admin = new User();

        $admin->setEmail('admin@madalynn.eu');
        $admin->setUsername('admin');
        $this->encryptPassword($admin, 'admin');

        $em->persist($admin);
        $em->flush();

        $this->addReference('user_admin', $admin);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * Encrypt the password for the current user
     *
     * @param User $user The user
     * @param type $password The plain password to encrypt
     *
     * @return User The same instance with the encrypted password
     */
    private function encryptPassword(User $user, $password)
    {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

        return $user;
    }
}