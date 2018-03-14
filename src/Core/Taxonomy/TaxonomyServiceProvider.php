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

		if ( function_exists('register_extended_taxonomy') ) {

			$taxonomies = apply_filters('owc/pdc_base/before_register_taxonomies', $this->plugin->config->get('taxonomies'));

			foreach ( $taxonomies as $taxonomyName => $taxonomy ) {

				// Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
				register_extended_taxonomy($taxonomyName, $taxonomy['object_types'], $taxonomy['args'], $taxonomy['names']);
			}
		}
	}
}