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

namespace Madalynn\Bundle\MainBundle\Twig\Extension;

use Madalynn\Bundle\MainBundle\Entity\AndroircVersion;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The sandbox extension
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class SandboxExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Contructor
     *
     * @param ContainerInterface $container The container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'display_changelog' => new \Twig_Function_Method($this, 'displayChangelog', array('is_safe' => array('html'))),
        );
    }

    /**
     * Displays a changelog
     *
     * @param string $version The string representation of a version
     *
     * @return string The changelog
     */
    public function displayChangelog($version)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $repo = $em->getRepository('MainBundle:ChangeLog');

        $version = $em->getRepository('MainBundle:AndroircVersion')
                      ->populate(AndroircVersion::create($version));

        if (null === $version) {
            return '';
        }

        $changelog = $repo->findByVersion($version);

        if (null === $changelog) {
            return '';
        }

        return $changelog->getChanges();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sandbox';
    }
}
