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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ill_data_cite_doi');
        $rootNode
                ->children()
                    ->scalarNode('username')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode("prefix")->isRequired()->cannotBeEmpty()->end()
                    /*
                     * if set to true, a special test prefix of 10.5072 will be used. This test prefix is available to all
                     * data centres. The test DOIs with this prefix will behave like an other DOI, e.g. they can be normally resolved.
                     * They will not be exposed by upcoming services like search and OAI, though. Periodically, all of these test
                     * datasets are purged from the system
                     */
                    ->scalarNode("test")->defaultValue(false)->end()
                    /*
                     * if set to true a request will not change the database nor will the DOI handle be registered or updated
                     * A query parameter of testMode=true is added to every request
                     */
                    ->scalarNode('testMode')->defaultValue(false)->end()
                    // allow the use of a proxy for cURL requests
                    ->arrayNode('proxy')
                        ->children()
                            ->scalarNode('host')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('port')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('username')->defaultValue(null)->end()
                            ->scalarNode('password')->defaultValue(null)->end()
                        ->end()
                    ->end()
                    ->scalarNode('domain')->isRequired()->cannotBeEmpty()->end()
                    ->arrayNode('identifier_types')
                        ->prototype('array')
                            ->children()
                              ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                              ->scalarNode('pattern')->isRequired()->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
