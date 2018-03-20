<?php

namespace OWC_PDC_Base\Core\RestApi;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class RestApiServiceProvider extends ServiceProvider
{

	/**
	 * @var string
	 */
	private $prefix = '_owc_';

	public function register()
	{

		$this->plugin->loader->addFilter('rest_api_init', $this, 'registerRestApiEndpoints');
	}

	/**
	 * register endpoints for use in the RestAPI.
	 */
	public function registerRestApiEndpoints()
	{



	}
}