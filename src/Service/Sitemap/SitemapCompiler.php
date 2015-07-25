<?php
namespace Werkint\Bundle\SitemapBundle\Service\Sitemap;

use JMS\ObjectRouting\ObjectRouter;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

/**
 * SitemapCompiler.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class SitemapCompiler
{
    protected $router;
    protected $objectRouter;
    protected $langs;
    protected $defaultLocale;

    /**
     * @param RouterInterface $router
     * @param ObjectRouter $objectRouter
     * @param array $langs
     * @param string $defaultLocale
     */
    public function __construct(
        RouterInterface $router,
        ObjectRouter $objectRouter,
        array $langs,
        $defaultLocale
    )
    {
        $this->router = $router;
        $this->objectRouter = $objectRouter;
        $this->langs = $langs;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param $link
     * @param $dataLang
     * @return string
     */
    protected function pathGenerator($link, $dataLang = null)
    {
        if (!isset($link[2])) {
            $link[2] = [];
        }
        if (!isset($link[1])) {
            $link[1] = [];
        }
        if (is_object($link[1])) {
            $path = $this->objectRouter->generate($link[0], $link[1], true, $link[2] + ($dataLang == null ? ['_locale' => $dataLang] : []));
        } else {
            $path = $this->router->generate($link[0], $link[1] + ($dataLang == null ? ['_locale' => $dataLang] : []), Router::ABSOLUTE_URL);
        }
        return $path;
    }

    /**
     * @param array $links
     * @return string
     */
    public function generateSitemap(array $links)
    {
        // TODO: очень устарел
        $data = [];
        $defLang = $this->defaultLocale;

        $data[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $data[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        foreach ($links as $link) {
            $path = $this->pathGenerator($link, $defLang);
            $data[] = '<url>';
            $data[] = '<loc>' . $path . '</loc>';
            foreach ($this->langs as $lang) {
                if ($lang == $defLang) {
                    continue;
                }
                if (count($this->langs) < 2) {
                    $path = $this->pathGenerator($link);
                } else {
                    $path = $this->pathGenerator($link, $lang);
                }
                $data[] = sprintf(
                    '<xhtml:link rel="alternate" hreflang="%s" href="%s"/>',
                    $lang,
                    $path
                );
            }
            $data[] = '</url>';
        }
        $data[] = '</urlset>';

        return join("\n", $data);
    }

}