<?php

namespace ILL\DataCiteDOIBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Bridge\Monolog\Logger;
use Monolog\Handler\StreamHandler;
/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
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
