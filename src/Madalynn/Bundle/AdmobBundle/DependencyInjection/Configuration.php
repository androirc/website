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

namespace Madalynn\Bundle\AdmobBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Tree Configuration
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('madalynn_admob', 'array');

        $rootNode
            ->children()
                ->scalarNode('publisher_id')->isRequired()->end()
                ->scalarNode('test_mode')->defaultValue('%kernel.debug%')->end()
                ->scalarNode('bgcolor')->defaultValue('FFFFFF')->end()
                ->scalarNode('textcolor')->defaultValue('000000')->end()
            ->end();

        return $treeBuilder;
    }
}
