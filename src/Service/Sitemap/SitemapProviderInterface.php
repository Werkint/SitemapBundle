<?php
namespace Werkint\Bundle\SitemapBundle\Service\Sitemap;

/**
 * SitemapProviderInterface.
 *
 * @author Aleksey
 */
interface SitemapProviderInterface
{
    /**
     * @return array
     */
    public function getLinks();
} 