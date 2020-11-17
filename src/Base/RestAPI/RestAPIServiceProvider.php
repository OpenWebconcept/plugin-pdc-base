<?php

/**
 * Provider which registers the API.
 */

namespace OWC\PDC\Base\RestAPI;

use OWC\PDC\Base\Foundation\ServiceProvider;
use WP_REST_Server;

/**
 *  @OA\Server(
 *    url="https://{site}/wp-json/owc/openpdc/v1",
 *    description=""
 *  ).
 *  @OA\Info(
 *    title="Yard | Digital Agency, OpenPdc API",
 *    version="3.0.3",
 *    termsOfService="https://www.yard.nl/",
 *    @OA\Contact(
 *      name="Yard | Digital Agency",
 *      url="https://www.yard.nl/",
 *      email="info@yard.nl"
 *    ),
 *    x={
 *      "logo": {
 *         "url": "https://www.yard.nl/wp-content/themes/theme-fusion/assets/img/logo-yard-da.svg"
 *      },
 *      "description": {
 *         "$ref"="../chapters/description.md"
 *      },
 *      "externalDocs": {
 *         "description": "Find out how to create Github repo for your OpenAPI spec.",
 *         "url": "https://openwebconcept.bitbucket.io/openpdc/"
 *       }
 *    },
 *    @OA\License(
 *      name="OpenWebConcept",
 *      url="https://www.openwebconcept.nl/"
 *    )
 * )
 */
class RestAPIServiceProvider extends ServiceProvider
{

    /**
     * The endpoint of the base API.
     *
     * @var string $namespace
     */
    private $namespace = 'owc/pdc/v1';

    /**
     * Registers the API.
     *
     * @return void
     */
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
     * @link https://url/wp-json/owc/pdc/v1
     *
     * Endpoint of the pdc-items.
     * @link https://url/wp-json/owc/pdc/v1/items
     *
     * Endpoint of the pdc-item detail page.
     * @link https://url/wp-json/owc/pdc/v1/items/{id|slug}
     *
     * Endpoint of the thema-items.
     * @link https://url/wp-json/owc/pdc/v1/themas
     *
     * Endpoint of the thema detail page.
     * @link https://url/wp-json/owc/pdc/v1/themas/{id}
     *
     * Endpoint of the subthema-items.
     * @link https://url/wp-json/owc/pdc/v1/subthemas
     *
     * Endpoint of the subthema detail page.
     * @link https://url/wp-json/owc/pdc/v1/subthemas/{id}
     *
     * Endpoint of searching.
     * @link https://url/wp-json/owc/pdc/v1/search
     *
     * @return void
     */
    public function registerRoutes()
    {
        \register_rest_route($this->namespace, 'items', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\ItemController($this->plugin), 'getItems'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'items/(?P<id>\d+)', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\ItemController($this->plugin), 'getItem'],
            'permission_callback' => '__return_true',
        ]);

        /** {slug}/internal should be ignored */
        \register_rest_route($this->namespace, 'items/(?P<slug>(?!.*internal)[\w-]+)', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\ItemController($this->plugin), 'getItemBySlug'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'them(a|e)s', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\ThemaController($this->plugin), 'getThemas'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'them(a|e)s/(?P<id>\d+)', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\ThemaController($this->plugin), 'getThema'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'them(a|e)s/(?P<slug>(?!.*internal)[\w-]+)', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\ThemaController($this->plugin), 'getThemaBySlug'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'subthem(a|e)s', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\SubthemaController($this->plugin), 'getSubthemas'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'subthem(a|e)s/(?P<id>\d+)', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\SubthemaController($this->plugin), 'getSubthema'],
            'permission_callback' => '__return_true',
        ]);

        \register_rest_route($this->namespace, 'subthem(a|e)s/(?P<slug>(?!.*internal)[\w-]+)', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [new Controllers\SubthemaController($this->plugin), 'getSubThemaBySlug'],
            'permission_callback' => '__return_true',
        ]);

        if ($this->plugin->settings->useGroupLayer()) {
            \register_rest_route($this->namespace, 'groups', [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [new Controllers\GroupController($this->plugin), 'getGroups'],
                'permission_callback' => '__return_true',
            ]);
        }

        if ($this->plugin->settings->useGroupLayer()) {
            \register_rest_route($this->namespace, 'groups/(?P<id>\d+)', [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [new Controllers\GroupController($this->plugin), 'getGroup'],
                'permission_callback' => '__return_true',
            ]);
        }

        $searchController = new Controllers\SearchController($this->plugin);
        \register_rest_route($this->namespace, 'search', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [$searchController, 'search'],
            'args'     => $searchController->arguments(),
            'permission_callback' => '__return_true',
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
            'methods'       => ['GET'],
        ];

        return $whitelist;
    }

    /**
     * Register fields for all configured posttypes.
     *
     * @return void
     */
    private function registerModelFields()
    {
        // Add global fields for all Models.
        foreach ($this->plugin->config->get('api.models') as $posttype => $data) {
            foreach ($data['fields'] as $key => $creator) {
                $class = '\OWC\PDC\Base\Repositories\\' . ucfirst($posttype);
                if (class_exists($class)) {
                    $creator = new $creator($this->plugin);
                    $class::addGlobalField($key, $creator, function () use ($creator) {
                        return $creator->executeCondition()();
                    });
                }
            }
        }
    }
}
