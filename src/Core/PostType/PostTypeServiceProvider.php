<?php

namespace OWC_PDC_Base\Core\PostType;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class PostTypeServiceProvider extends ServiceProvider
{

	public function register()
	{

		$this->plugin->loader->addAction('init', $this, 'registerPostTypes');
	}

	/**
	 * register custom posttypes.
	 */
	public function registerPostTypes()
	{

		if ( function_exists('register_extended_post_type') ) {

			$postTypes = apply_filters('owc/pdc_base/before_register_posttypes', $this->plugin->config->get('posttypes'));

			foreach ( $postTypes as $postTypeName => $postType ) {

				// Examples of registering post types: http://johnbillion.com/extended-cpts/
				register_extended_post_type($postTypeName, $postType['args'], $postType['names']);
			}
		}
	}
}