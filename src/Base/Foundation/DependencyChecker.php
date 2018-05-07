<?php

namespace OWC\PDC\Base\Foundation;

class DependencyChecker
{

    /**
     * @var array
     */
    private $plugins;

    /**
     * Determine which plugins need to be present.
     *
     * @param array $plugins
     */
    public function __construct(array $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * Determines if the dependencies are not met.
     *
     * @return bool
     */
    public function fails(): bool
    {
        foreach ($this->plugins as $plugin) {
            var_dump($plugin);die;
        }
    }

}