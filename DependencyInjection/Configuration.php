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
* This information is solely responsible for how the different configuration
* sections are normalised, and merged.
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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ill_data_cite_doi');
        $rootNode
                ->children()
                ->scalarNode('username')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('default')->defaultValue('mm')->end()
                ->arrayNode('proxy')
                    ->children()
                        ->scalarNode('url')->defaultValue(null)->end()
                        ->scalarNode('port')->defaultValue(null)->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}