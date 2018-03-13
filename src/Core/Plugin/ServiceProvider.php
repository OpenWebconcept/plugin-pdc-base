<?php

namespace OWC_PDC_Base\Core\Plugin;

abstract class ServiceProvider
{

    /**
     * Instance of the plugin.
     *
     * @var \OWC_PDC_Base\Core\Plugin\BasePlugin
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