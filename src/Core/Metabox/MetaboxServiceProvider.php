<?php

namespace OWC_PDC_Base\Core\Metabox;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;
use OWC_PDC_Base\Core\Metabox\MetaboxBaseServiceProvider;

class MetaboxServiceProvider extends MetaboxBaseServiceProvider
{

	public function register()
	{

		$this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes', 10, 1);
	}

	/**
	 * register metaboxes.
	 */
	public function registerMetaboxes($rwmbMetaboxes)
	{
		$configMetaboxes = (array)apply_filters('owc/pdc_base/config/metaboxes', $this->plugin->config->get('metaboxes'));
		$metaboxes        = [];

		foreach ( $configMetaboxes as $metabox ) {

			$metaboxes[] = $this->processMetabox($metabox);
		}

		return array_merge( $rwmbMetaboxes, apply_filters("owc/pdc_base/before_register_metaboxes", $metaboxes) );
	}
}