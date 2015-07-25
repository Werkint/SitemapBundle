<?php
namespace Werkint\Bundle\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for WerkintSitemapBundle.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @param string $alias
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        // @formatter:off
        $treeBuilder
            ->root($this->alias)
            ->children()
                ->scalarNode('target')->defaultValue('/sitemap.xml')->end()
                ->arrayNode('languages')
                     ->beforeNormalization()
                       ->ifTrue(function($v) { return $v === null; })
                       ->then(function($v) { return ['%kernel.default_locale%']; })
                     ->end()
                ->prototype('scalar')->end()
                ->end()
            ->end()
        ;
        // @formatter:on

        return $treeBuilder;
    }
}
