<?php
namespace Werkint\Bundle\SitemapBundle\Service\Sitemap;

/**
 * TODO: write "SitemapRoute" info
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class SitemapRoute
{
    /**
     * @var string
     */
    protected $route;
    /**
     * @var array
     */
    protected $parameters = [];
    /**
     * @var \DateTime|null
     */
    protected $lastModified;

    public function __construct(
        $route,
        array $parameters = []
    ) {
        $this->route = $route;
        $this->parameters = $parameters;
    }

    // -- Accessors ---------------------------------------

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTime|null $lastModified
     * @return $this
     */
    public function setLastModified(\DateTime $lastModified = null)
    {
        $this->lastModified = $lastModified;
        return $this;
    }
}