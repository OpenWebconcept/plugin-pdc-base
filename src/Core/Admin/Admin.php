<?php

namespace OWC_PDC_Base\Core\Admin;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;
use OWC_PDC_Base\Core\Plugin\BasePlugin;

class Admin
{

    /**
     * Instance of the plugin.
     *
     * @var $plugin \OWC_PDC_Base\Core\Plugin
     */
    protected $plugin;

    /**
     * Instance of the actions and filters loader.
     *
     * @var $plugin \OWC_PDC_Base\Core\Plugin\Loader
     */
    protected $loader;

    /**
     * Admin constructor.
     *
     * @param \OWC_PDC_Base\Core\Plugin\BasePLugin $plugin
     */
    public function __construct(BasePlugin $plugin)
    {
        $this->plugin = $plugin;
        $this->loader = $plugin->loader;
    }

    /**
     * Boot up the frontend
     */
    public function boot()
    {
        $this->bootServiceProviders();
    }

    /**
     * Boot service providers
     */
    private function bootServiceProviders()
    {
        $services = $this->plugin->config->get('core.providers.admin');

        foreach ($services as $service) {
            $service = new $service($this->plugin);

            if ( ! $service instanceof ServiceProvider) {
                throw new \Exception('Provider must extend ServiceProvider.');
            }

            /**
             * @var \OWC_PDC_Base\Core\Plugin\ServiceProvider $service
             */
            $service->register();
        }
    }

}