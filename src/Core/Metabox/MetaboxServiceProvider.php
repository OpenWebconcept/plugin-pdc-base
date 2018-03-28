<?php

namespace OWC_PDC_Base\Core\Metabox;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class MetaboxServiceProvider extends ServiceProvider
{

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

			$metaboxes[] = $this->processMetabox($metabox);
		}

		return array_merge( $rwmbMetaboxes, apply_filters("owc/pdc_base/before_register_metaboxes", $metaboxes) );
	}

	private function processMetabox(array $metabox)
	{
		foreach ( $metabox['fields'] as $fieldGroup ) {

			$fields = $this->processFieldGroup($fieldGroup);

		}
		$metabox['fields'] = $fields;

		return $metabox;
	}


	private function processFieldGroup($fieldGroup)
	{

		$fields = [];
		foreach ( $fieldGroup as $field ) {

			$fields[] = $this->addPrefix($field);
		}

		return $fields;
	}

	private function addPrefix($field)
	{

		if ( isset($field['id']) ) {
			$field['id'] = self::PREFIX . $field['id'];
		}

		return $field;
	}

}