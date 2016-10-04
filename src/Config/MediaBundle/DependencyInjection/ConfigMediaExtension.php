<?php

namespace Config\MediaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ConfigMediaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('config_media.upload_dir', $config['upload_dir']);
        $container->setParameter('config_media.contexts', $config['contexts']);
        $container->setParameter('config_media.extensions', $config['extensions']);
        $container->setParameter('config_media.mime_types', $config['mime_types']);
        $container->setParameter('config_media.max_upload_size', $config['max_upload_size']);
       

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
    
}
