<?php

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Plugin\ServiceProvider;
use OWC\PDC\Base\Plugin;

class Admin
{

    /**
     * Instance of the plugin.
     *
     * @var $plugin \OWC\PDC\Base\Plugin
     */
    protected $plugin;

    /**
     * Instance of the actions and filters loader.
     *
     * @var $plugin \OWC\PDC\Base\Plugin\Loader
     */
    protected $loader;

    /**
     * Admin constructor.
     *
     * @param \OWC\PDC\Base\Plugin $plugin
     */
    public function __construct(Plugin $plugin)
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
             * @var \OWC\PDC\Base\Plugin\ServiceProvider $service
             */
            $service->register();
        }
    }

}