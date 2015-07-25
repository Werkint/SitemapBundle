<?php
namespace Werkint\Bundle\SitemapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Werkint\Bundle\SitemapBundle\DependencyInjection\Compiler\SitemapProviderPass;

/**
 * WerkintSitemapBundle.
 */
class WerkintSitemapBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SitemapProviderPass());
    }
}
