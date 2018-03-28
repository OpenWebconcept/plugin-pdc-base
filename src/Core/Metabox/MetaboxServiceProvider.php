<?php

namespace OWC_PDC_Base\Core\Metabox;

use Illuminate\Support\Collection;
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
	public function registerMetaboxes($rwmbMetaboxes): array
	{

		return ( new Collection(apply_filters('owc/pdc_base/config/metaboxes', $this->plugin->config->get('metaboxes'))) )
			->map(function($metabox) {
				return $this->addPrefix($metabox);
			})
			->pipe(function($collection) {
				return new Collection(apply_filters("owc/pdc_base/before_register_metaboxes", $collection->toArray()));
			})
			->merge($rwmbMetaboxes)
			->values()
			->toArray();
	}

	private function addPrefix(array $metabox)
	{
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

		return $metabox;

	}

}