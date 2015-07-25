<?php
namespace Werkint\Bundle\SitemapBundle\Service\Sitemap;

/**
 * SitemapProviderInterface.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
interface SitemapProviderInterface
{
    /**
     * @return array|SitemapRoute[]
     */
    public function getRoutes();
} 