<?php

/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
* This class contains the configuration information for the bundle
*
* @author Mr. Jamie Hall <hall@ill.eu>
*/
class Configuration implements ConfigurationInterface
{
    /**
    * Generates the configuration tree.
    *
    * @return TreeBuilder
    */
    public function getConfigTreeBuilder()
    {
        $supportedAdapters = array('curl', 'socket');

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ill_data_cite_doi');
        $rootNode
                ->validate()
                    ->ifTrue(function($v){ return isset($v['proxy']) && 'curl' !== $v['adapter'];})
                    ->thenInvalid('Proxy support is only available to the curl adapter.')
                ->end()
                ->children()
                    ->scalarNode('username')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('adapter')
                        ->validate()
                            ->ifNotInArray($supportedAdapters)
                            ->thenInvalid('The adapter %s is not supported. Please choose one of '.json_encode($supportedAdapters))
                        ->end()
                        ->cannotBeOverwritten()
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    // allow the use of a proxy for cURL requests
                    ->arrayNode('proxy')
                        ->children()
                            ->scalarNode('host')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('port')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('username')->defaultValue(null)->end()
                            ->scalarNode('password')->defaultValue(null)->end()
                        ->end()
                ->end();

        return $treeBuilder;
    }
}