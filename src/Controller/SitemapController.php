<?php
namespace Werkint\Bundle\SitemapBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Werkint\Bundle\SitemapBundle\Service\Sitemap\Sitemap;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Вспомогательный контроллер для проверки sitemap.xml
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class SitemapController
{
    /**
     * @DI\Inject("werkint_sitemap.sitemap")
     * @var Sitemap
     */
    private $sitemap;

    // -- Actions ---------------------------------------

    /**
     * @Rest\Get("/%werkint_sitemap.target%")
     */
    public function sitemapAction()
    {
        return new Response($this->sitemap->dump());
    }
}
