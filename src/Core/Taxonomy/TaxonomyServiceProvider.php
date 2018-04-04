<?php

namespace OWC_PDC_Base\Core\Taxonomy;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider
{

	/**
	 * the array of taxonomies definitions from the config
	 *
	 * @var array
	 */
	protected $configTaxonomies = [];

	public function register()
	{

		$this->plugin->loader->addAction('init', $this, 'registerTaxonomies');
		$this->configTaxonomies = apply_filters('owc/pdc_base/config/taxonomies', $this->plugin->config->get('taxonomies'));
	}

	/**
	 * @return array
	 */
	public function getConfigTaxonomies()
	{
		return $this->configTaxonomies;
	}

	/**
	 * Register custom taxonomies via extended_cpts
	 */
	public function registerTaxonomies()
	{

		if ( function_exists('register_extended_taxonomy') ) {

			foreach ( $this->configTaxonomies as $taxonomyName => $taxonomy ) {

				// Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
				register_extended_taxonomy($taxonomyName, $taxonomy['object_types'], $taxonomy['args'], $taxonomy['names']);
			}
		}
	}
}