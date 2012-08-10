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

namespace Madalynn\Bundle\DebugBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;

/**
 * AndroIRC debug extension
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class DebugExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();

        $config = $processor->processConfiguration($configuration, $configs);
        $container->setParameter('androirc.translations', $config['translations']);
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespace()
    {
        return 'http://www.androirc.com/schema/dic/debug';
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'debug';
    }
}
