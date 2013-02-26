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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class ILLDataCiteDOIExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // the custom logger for the bundle
        $logger =  new Reference('ill_data_cite_doi.logger');

        // inject the logger and bundle configuration values into the services
        $container->getDefinition("ill_data_cite_doi.manager")->setArguments(array($config, $logger));
        $container->getDefinition("ill_data_cite_doi.metadata_manager")->setArguments(array($config, $logger));
    }
}
