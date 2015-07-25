<?php
namespace Werkint\Bundle\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * SitemapProviderPass.
 *
 * @author Odesskij<odesskij1992@gmail.com>
 */
class SitemapProviderPass implements
    CompilerPassInterface
{
    const CLASS_SRV = 'werkint_sitemap.sitemap';
    const CLASS_TAG = 'werkint_sitemap.provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(static::CLASS_SRV)) {
            return;
        }
        $definition = $container->getDefinition(
            static::CLASS_SRV
        );

        $list = $container->findTaggedServiceIds(static::CLASS_TAG);
        foreach ($list as $id => $attributes) {
            $definition->addMethodCall(
                'addProvider', [
                    new Reference($id),
                ]
            );
        }
    }
}