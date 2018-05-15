<?php

namespace OWC\PDC\Base\RestAPI;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\Models\ItemModel;

class RestAPIServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->plugin->loader->addFilter('owc/config-expander/rest-api/whitelist', $this, 'filterEndpointsWhitelist',
            10, 1);
        $this->plugin->loader->addFilter('rest_api_init', $this, 'registerRestAPIEndpointsFields', 10);
        $this->plugin->loader->addFilter('rest_prepare_pdc-item', $this, 'filterRestPreparePdcItem', 10, 3);

        foreach ($this->plugin->config->get('api.item.fields') as $key => $creator) {
            ItemModel::addField($key, new $creator($this->plugin));
        }

    }

    /**
     * register endpoint fields for use in the RestAPI.
     */
    public function registerRestAPIEndpointsFields()
    {

        $restApiFieldsPerPostType = $this->plugin->config->get('rest_api_fields');

        foreach ($restApiFieldsPerPostType as $postType => $restApiFields) {

            $this->registerRestFieldByPostType($postType, $restApiFields);
        }
    }

    private function registerRestFieldByPostType($postType, $restApiFields)
    {
        if (post_type_exists($postType)) {

            foreach ($restApiFields as $attribute => $restApiField) {

                register_rest_field($postType, $attribute, $restApiField);
            }
        }
    }

    public function filterEndpointsWhitelist($endpointsWhitelist)
    {
        //remove default root endpoint
        unset($endpointsWhitelist['wp/v2']);

        $endpointsWhitelist['wp/v2'] = [
            'endpoint_stub' => '/wp/v2/pdc',
            'methods'       => [ 'GET' ]
        ];

        return $endpointsWhitelist;
    }

    public function filterRestPreparePdcItem($response, $post, $request)
    {

        $requestAttributes = $request->get_attributes();
        $requestParams = $request->get_params();

        //check for usage in list of pdc_items via check for 'get_items' callback method.
        if ('get_items' == $requestAttributes['callback'][1] && ! isset($requestParams['slug'])) {

            $response->data['connected']['pdc-item_to_pdc-subcategory'] = [];
            if ( ! empty($response->data['connected']['pdc-item_to_pdc-subcategory'] = $post->connected)) {
                $response->data['connected']['pdc-item_to_pdc-subcategory'] = $post->connected;
            }
        }

        return $response;
    }

}