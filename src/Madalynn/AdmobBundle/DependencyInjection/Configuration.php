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

namespace Madalynn\AdmobBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Tree Configuration
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('madalynn_admob', 'array');

        $rootNode
            ->children()
                ->scalarNode('publisher_id')->isRequired()->end()
                ->scalarNode('analytics_id')->isRequired()->end()
                ->scalarNode('ad_request')->defaultValue(true)->end()
                ->scalarNode('analytics_request')->defaultValue(false)->end()
                ->scalarNode('test_mode')->defaultValue('%kernel.debug%')->end()
                ->arrayNode('options')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')
                ->end()
        ->end();

        return $treeBuilder;
    }
}