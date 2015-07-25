<?php
namespace Werkint\Bundle\SitemapBundle\Service\Sitemap;

use Symfony\Component\Templating\EngineInterface;

/**
 * Компилирует sitemap.xml
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class SitemapCompiler
{
    const TEMPLATE = '@WerkintSitemap/Sitemap/sitemap.xml.twig';

    protected $templating;
    protected $langs;
    protected $defaultLocale;

    /**
     * @param EngineInterface $templating
     * @param array           $langs
     * @param string          $defaultLocale
     */
    public function __construct(
        EngineInterface $templating,
        array $langs,
        $defaultLocale
    ) {
        $this->templating = $templating;
        $this->langs = $langs;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param array $links
     * @return string
     */
    public function generateSitemap(array $links)
    {
        if (($key = array_search($this->defaultLocale, $this->langs)) !== false) {
            unset($this->langs[$key]);
        }

        return $this->templating->render(static::TEMPLATE, [
            'routes'         => $links,
            'default_locale' => $this->defaultLocale,
            'locales'        => $this->langs,
        ]);
    }
}