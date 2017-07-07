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

namespace Madalynn\Bundle\MainBundle\Twig;

use Madalynn\Bundle\MainBundle\Twig\Extension\SandboxExtension;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A custom sandboxed twig parser for blog article
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class SandboxParser implements ContainerAwareInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->twig = null;
    }

    /**
     * Parses a blog content for Twig tags
     *
     * @param string $text
     */
    public function parse($text)
    {
        if (null === $this->twig) {
            $this->twig = $this->getTwig();
        }

        try {
            return $this->twig->createTemplate($text)->render(array());
        } catch (\Twig_Error_Syntax $e) {
            return '<p>Mhh.. Unable to display this article</p>';
        }
    }

    /**
     * Gets a new sandboxed Twig environment
     *
     * @return \Twig_Environment
     */
    protected function getTwig()
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Array(array()));
        $twig->addExtension(new SandboxExtension($this->container));

        return $twig;
    }

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
