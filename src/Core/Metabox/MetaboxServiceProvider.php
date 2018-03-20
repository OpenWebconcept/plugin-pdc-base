<?php

namespace OWC_PDC_Base\Core\Metabox;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class MetaboxServiceProvider extends ServiceProvider
{

	/**
	 * @var string
	 */
	private $prefix = '_owc_';

	public function register()
	{

		$this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes');
	}

	/**
	 * register metaboxes.
	 */
	public function registerMetaboxes()
	{

		$metaboxes      = (array) apply_filters('owc/pdc_base/config/metaboxes', $this->plugin->config->get('metaboxes'));
		$rwmb_metaboxes = [];

		foreach ( $metaboxes as $metabox ) {

			foreach ( $metabox['fields'] as $field_group ) {

				foreach ( $field_group as $field ) {

					if ( isset($field['id']) ) {
						$field['id'] = $this->prefix . $field['id'];
					}
					$rwmb_fields[] = $field;
				}
			}
			$metabox['fields'] = $rwmb_fields;
			$rwmb_metaboxes[]  = $metabox;
		}

		$rwmb_metaboxes = apply_filters("owc/pdc_base/before_register_metaboxes", $rwmb_metaboxes );

		return $rwmb_metaboxes;
	}
}