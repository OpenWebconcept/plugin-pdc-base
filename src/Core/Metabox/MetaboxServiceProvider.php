<?php

namespace OWC_PDC_Base\Core\Metabox;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class MetaboxServiceProvider extends ServiceProvider
{

	/**
	 * @var string
	 */
	const PREFIX = '_owc_';

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

			$fields = [];
			foreach ( $metabox['fields'] as $fieldGroup ) {

				foreach ( $fieldGroup as $field ) {

					if ( isset($field['id']) ) {
						$field['id'] = self::PREFIX . $field['id'];
					}
					$fields[] = $field;
				}
			}
			$metabox['fields'] = $fields;
			$metaboxes[]       = $metabox;
		}

		$metaboxes = apply_filters("owc/pdc_base/before_register_metaboxes", $metaboxes);

		foreach ( $metaboxes as $metabox ) {
			$rwmbMetaboxes[] = $metabox;
		}

		return $rwmbMetaboxes;
	}
}