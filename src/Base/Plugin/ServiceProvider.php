<?php

namespace OWC\PDC\Base\Plugin;

abstract class ServiceProvider
{

    /**
     * Instance of the plugin.
     *
     * @var \OWC\PDC\Base\Plugin\BasePlugin
     */
    protected $plugin;

    public function __construct(BasePlugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Register the service provider.
     */
    public abstract function register();

}