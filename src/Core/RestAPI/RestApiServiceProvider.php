<?php

namespace OWC_PDC_Base\Core\RestApi;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

//use OWC_PDC_Base\Core\PostType\PostTypes\PdcItem;

class RestApiServiceProvider extends ServiceProvider
{

	public function register()
	{
		//$this->plugin->loader->addFilter('config_expander_admin_defaults', $this, 'filterConfigExpanderDefaults', 10, 1);
		//$this->plugin->loader->addFilter('config_expander_rest_endpoints_whitelist', $this,'filterEndpointsWhitelist', 10, 1);
		$this->plugin->loader->addFilter('rest_api_init', $this, 'registerRestApiEndpointsFields', 10);
	}

	/**
	 * register endpoint fields for use in the RestAPI.
	 */
	public function registerRestApiEndpointsFields()
	{

		$restApiFieldsPerPostType = apply_filters('owc/pdc_base/config/rest_api_fields_per_posttype', $this->plugin->config->get('rest_api_fields'));

		foreach ( $restApiFieldsPerPostType as $postType => $restApiFields ) {

			$this->registerRestFieldByPostType($postType, $restApiFields);
		}
	}

	private function registerRestFieldByPostType($postType, $restApiFields)
	{
		if ( post_type_exists($postType) ) {

			foreach ( $restApiFields as $attribute => $restApiField ) {

				register_rest_field($postType, $attribute, $restApiField);
			}
		}
	}

	public function filterConfigExpanderDefaults($defaults)
	{
		$defaults['DISABLE_REST_API'] = false;

		return $defaults;
	}

	public function filterEndpointsWhitelist($endpoints_whitelist)
	{

		//remove default root endpoint
		unset($endpoints_whitelist['wp/v2']);

		$endpoints_whitelist['wp/v2'] = [
			'endpoint_stub' => '/wp/v2/pdc',
			'methods'       => ['GET']
		];

		return $endpoints_whitelist;
	}

}