<?php

namespace OWC_PDC_Base\Core\Taxonomy;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider
{

	public function register()
	{

		$this->plugin->loader->addAction('init', $this, 'registerTaxonomies');
	}

	/**
	 * register taxonomies.
	 */
	public function registerTaxonomies()
	{

		if ( function_exists('register_extended_taxonomies') ) {

			$taxonomies = apply_filters('owc_pdc_base_taxonomies', $this->plugin->config->get('taxonomies'));

			foreach ( $taxonomies as $taxonomyName => $taxonomy ) {

				// Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
				register_extended_taxonomy($taxonomyName, $taxonomy['objectTypes'], $taxonomy['args'], $taxonomy['names']);
			}
		}
	}
}