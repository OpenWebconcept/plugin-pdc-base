<?php

namespace OWC\PDC\Base\RestAPI;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\Models\Item;

class RestAPIServiceProvider extends ServiceProvider
{

    private $namespace = 'owc/pdc/v1';

    public function register()
    {
        $this->plugin->loader->addFilter('rest_api_init', $this, 'registerRoutes');
        $this->plugin->loader->addFilter('owc/config-expander/rest-api/whitelist', $this, 'whitelist', 10, 1);

        // Add global fields for PDC items.
        foreach ($this->plugin->config->get('api.item.fields') as $key => $creator) {
            Item::addGlobalField($key, new $creator($this->plugin));
        }
    }

    /**
     * Register routes on the rest API.
     *
     * @return void
     */
    public function registerRoutes()
    {
        register_rest_route($this->namespace, 'items', [
            'methods'  => 'GET',
            'callback' => [ new Controllers\ItemController, 'getItems' ],
        ]);

        register_rest_route($this->namespace, 'items/(?P<id>\d+)', [
            'methods'  => 'GET',
            'callback' => [ new Controllers\ItemController, 'getItem' ],
        ]);
    }

    /**
     * Whitelist endpoints within Config Expander.
     *
     * @param $whitelist
     *
     * @return array
     */
    public function whitelist($whitelist): array
    {
        // Remove default root endpoint
        unset($whitelist['wp/v2']);

        //$endpointsWhitelist['wp/v2'] = [
        //    'endpoint_stub' => '/wp/v2/pdc',
        //    'methods'       => [ 'GET' ]
        //];

        return $whitelist;
    }

}