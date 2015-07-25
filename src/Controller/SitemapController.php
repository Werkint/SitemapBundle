<?php
namespace Werkint\Bundle\SitemapBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TODO: write "SitemapController" info
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class SitemapController
{
    /**
     * @Rest\Get("/%werkint_sitemap.target%")
     * @Rest\View()
     */
    public function sitemapAction()
    {
        throw new \Exception('Not implemented');
    }
}
