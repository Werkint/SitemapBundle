<?php
namespace Werkint\Bundle\SitemapBundle\Service\Sitemap;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Werkint\Bundle\FrameworkExtraBundle\Service\Logger\IndentedLoggerInterface;
use Werkint\Bundle\CommandBundle\Service\Processor\Compile\CompileProviderInterface;

/**
 * Sitemap.
 *
 * @author Aleksey
 * @author Odesskij<odesskij1992@gmail.com>
 */
class Sitemap implements
    CompileProviderInterface
{
    protected $filepath;
    protected $compiler;

    /**
     * @param SitemapCompiler $compiler
     * @param                 $filepath
     */
    public function __construct(
        SitemapCompiler $compiler,
        $filepath
    )
    {
        $this->filepath = $filepath;
        $this->compiler = $compiler;
    }

    /**
     * {@inheritdoc}
     */
    public function process(
        IndentedLoggerInterface $out,
        ContainerAwareCommand $command = null
    )
    {
        $links = $this->getLinks();
        $data = $this->compiler->generateSitemap($links);
        file_put_contents($this->filepath, $data);
        $out->writeln(count($links) . ' links processed');
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
                $provider->getLinks()
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
    )
    {
        $this->providers[] = $provider;
    }
}