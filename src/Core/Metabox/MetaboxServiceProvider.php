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

		$this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes', 10, 1);
	}

	/**
	 * register metaboxes.
	 */
	public function registerMetaboxes($rwmb_metaboxes)
	{

		$config_metaboxes = (array)apply_filters('owc/pdc_base/config/metaboxes', $this->plugin->config->get('metaboxes'));
		$metaboxes        = [];

		foreach ( $config_metaboxes as $metabox ) {

			$fields = [];
			foreach ( $metabox['fields'] as $field_group ) {

				foreach ( $field_group as $field ) {

					if ( isset($field['id']) ) {
						$field['id'] = $this->prefix . $field['id'];
					}
					$fields[] = $field;
				}
			}
			$metabox['fields'] = $fields;
			$metaboxes[]       = $metabox;
		}

		$metaboxes = apply_filters("owc/pdc_base/before_register_metaboxes", $metaboxes);

		foreach ( $metaboxes as $metabox ) {
			$rwmb_metaboxes[] = $metabox;
		}

		return $rwmb_metaboxes;
	}
}