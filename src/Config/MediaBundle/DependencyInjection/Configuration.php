<?php

namespace Config\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('config_media');

        $rootNode
            ->children()
                ->scalarNode('upload_dir')
                    ->defaultValue('/uploads/media') 
                ->end()
                ->scalarNode('max_upload_size')
                    ->defaultValue('2')
                ->end()
                ->arrayNode('extensions')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'pdf', 'txt', 'rtf',
                        'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
                        'odt', 'odg', 'odp', 'ods', 'odc', 'odf', 'odb',
                        'csv',
                        'xml',
                        'jpg', 'png', 'jpeg','gif'
                    ))
                ->end()
                ->arrayNode('mime_types')
                    ->prototype('scalar')->end()
                        ->defaultValue(array(
                            'application/pdf', 'application/x-pdf', 'application/rtf', 'text/html', 'text/rtf', 'text/plain',
                            'application/excel','application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint',
                            'application/vnd.ms-powerpoint', 'application/vnd.oasis.opendocument.text', 'application/vnd.oasis.opendocument.graphics', 'application/vnd.oasis.opendocument.presentation', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.chart', 'application/vnd.oasis.opendocument.formula', 'application/vnd.oasis.opendocument.database', 'application/vnd.oasis.opendocument.image',
                            'text/comma-separated-values',
                            'text/xml', 'application/xml',
                            'application/zip',
                            'image/pjpeg','image/jpeg', 'image/png','image/x-png','image/gif'
                        ))
                ->end()
            ->end()
        ;
        $this->addContextsSection($rootNode);
        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addContextsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('contexts')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('formats')
                                ->isRequired()
                                ->useAttributeAsKey('id')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('width')->defaultValue(false)->end()
                                        ->scalarNode('height')->defaultValue(false)->end()
                                        ->scalarNode('quality')->defaultValue(80)->end()
                                        ->scalarNode('format')->defaultValue('jpg')->end()
                                        ->scalarNode('constraint')->defaultValue(true)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
