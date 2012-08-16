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

namespace Madalynn\Bundle\MainBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * AndroIRC main extension
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class MainExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.xml');
        $loader->load('listeners.xml');
        $loader->load('templating.xml');
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespace()
    {
        return 'http://www.androirc.com/schema/dic/main';
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'main';
    }
}
