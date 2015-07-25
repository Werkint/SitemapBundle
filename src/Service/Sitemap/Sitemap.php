<?php
namespace Werkint\Bundle\SitemapBundle\Service\Sitemap;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Werkint\Bundle\CommandBundle\Service\Processor\Compile\CompileProviderInterface;
use Werkint\Bundle\FrameworkExtraBundle\Service\Logger\IndentedLoggerInterface;

/**
 * Строит sitemap.xml для сайта
 *
 * @author Aleksey
 * @author Odesskij<odesskij1992@gmail.com>
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class Sitemap implements
    CompileProviderInterface
{
    protected $filepath;
    protected $filedir;
    protected $compiler;

    /**
     * @param SitemapCompiler $compiler
     * @param string          $filepath
     * @param string          $filedir
     */
    public function __construct(
        SitemapCompiler $compiler,
        $filedir,
        $filepath
    ) {
        $this->filepath = $filepath;
        $this->filedir = $filedir;
        $this->compiler = $compiler;
    }

    /**
     * {@inheritdoc}
     */
    public function process(
        IndentedLoggerInterface $out,
        ContainerAwareCommand $command = null
    ) {
        $links = $this->getLinks();
        $data = $this->compiler->generateSitemap($links);
        file_put_contents($this->filedir . '/' . $this->filepath, $data);
        $out->writeln(count($links) . ' links processed');
    }

    /**
     * @return string
     */
    public function dump()
    {
        $links = $this->getLinks();
        return $this->compiler->generateSitemap($links);
    }

    /**
     * @return array
     */
    protected function getLinks()
    {
        $links = [];
        foreach ($this->providers as $provider) {
            $links = array_merge(
                $links,
                $provider->getRoutes()
            );
        }
        return $links;
    }



    // -- Providers ---------------------------------------

    /** @var SitemapProviderInterface[] */
    protected $providers = [];

    /**
     * @param SitemapProviderInterface $provider
     */
    public function addProvider(
        SitemapProviderInterface $provider
    ) {
        $this->providers[] = $provider;
    }
}