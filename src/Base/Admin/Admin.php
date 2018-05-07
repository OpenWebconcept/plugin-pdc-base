<?php

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\Foundation\Plugin;

class Admin
{

    /**
     * Instance of the plugin.
     *
     * @var $plugin \OWC\PDC\Base\Foundation\Plugin
     */
    protected $plugin;

    /**
     * Instance of the actions and filters loader.
     *
     * @var $plugin \OWC\PDC\Base\Foundation\Loader
     */
    protected $loader;

    /**
     * Admin constructor.
     *
     * @param \OWC\PDC\Base\Foundation\Plugin $plugin
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
             * @var \OWC\PDC\Base\Foundation\ServiceProvider $service
             */
            $service->register();
        }
    }

}