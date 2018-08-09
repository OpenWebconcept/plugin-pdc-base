<?php

namespace OWC\PDC\Base\RestAPI;

use OWC\PDC\Base\Foundation\ServiceProvider;

class RestAPIServiceProvider extends ServiceProvider
{

    /**
     * The endpoint of the base API.
     *
     * @var string $namespace
     */
    private $namespace = 'owc/pdc/v1';

    public function register()
    {
        $this->plugin->loader->addAction('rest_api_init', $this, 'registerRoutes');
        $this->plugin->loader->addFilter('owc/config-expander/rest-api/whitelist', $this, 'whitelist', 10, 1);

        $this->registerModelFields();
    }

    /**
     * Register routes on the rest API.
     *
     * Main endpoint.
     * @link https://{url}/wp-json/owc/pdc/v1
     *
     * Endpoint of the pdc-items.
     * @link https://{url}/wp-json/owc/pdc/v1/items 
     * 
     * Endpoint of the pdc-item detail page.
     * @link https://{url}/wp-json/owc/pdc/v1/items/{id}
     * 
     * Endpoint of the thema-items.
     * @link https://{url}/wp-json/owc/pdc/v1/themas
     * 
     * Endpoint of the thema detail page.
     * @link https://{url}/wp-json/owc/pdc/v1/themas/{id}
     * 
     * Endpoint of the subthema-items.
     * @link https://{url}/wp-json/owc/pdc/v1/subthemas
     * 
     * Endpoint of the subthema detail page.
     * @link https://{url}/wp-json/owc/pdc/v1/subthemas/{id}
     *
     * @return void
     */
    public function registerRoutes()
    {
        register_rest_route($this->namespace, 'items', [
            'methods' => 'GET',
            'callback' => [new Controllers\ItemController($this->plugin), 'getItems'],
        ]);

        register_rest_route($this->namespace, 'items/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [new Controllers\ItemController($this->plugin), 'getItem'],
        ]);

        register_rest_route($this->namespace, 'themas', [
            'methods' => 'GET',
            'callback' => [new Controllers\ThemaController($this->plugin), 'getThemas'],
        ]);

        register_rest_route($this->namespace, 'themas/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [new Controllers\ThemaController($this->plugin), 'getThema'],
        ]);

        register_rest_route($this->namespace, 'subthemas', [
            'methods' => 'GET',
            'callback' => [new Controllers\SubthemaController($this->plugin), 'getSubthemas'],
        ]);

        register_rest_route($this->namespace, 'subthemas/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [new Controllers\SubthemaController($this->plugin), 'getSubthema'],
        ]);
    }

    /**
     * Whitelist endpoints within Config Expander.
     *
     * @package OWC\ConfigExpander\DisableRestAPI\DisableRestAPI
     * @param array $whitelist
     *
     * @return array
     */
    public function whitelist($whitelist): array
    {
        // Remove default root endpoint
        unset($whitelist['wp/v2']);

        $whitelist[$this->namespace] = [
            'endpoint_stub' => '/' . $this->namespace,
            'methods' => ['GET'],
        ];

        return $whitelist;
    }

    /**
     * Register fields for all configured posttypes.
     */
    private function registerModelFields()
    {
        // Add global fields for all Models.
        foreach ($this->plugin->config->get('api.models') as $posttype => $data) {
            foreach ($data['fields'] as $key => $creator) {
                $class = '\OWC\PDC\Base\Models\\' . ucfirst($posttype);
                if (class_exists($class)) {
                    $class::addGlobalField($key, new $creator($this->plugin));
                }
            }
        }
    }

}
