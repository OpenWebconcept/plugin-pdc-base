<?php
/**
 * Provider which handles the metabox registration.
 */

namespace OWC\PDC\Base\Metabox;

use OWC\PDC\Base\Foundation\ServiceProvider;

/**
 * Provider which handles the metabox registration.
 */
abstract class MetaboxBaseServiceProvider extends ServiceProvider
{
    /**
     * Constant prefix for metabox.
     * 
     * @var string
     */
	const PREFIX = '_owc_';

	protected function processMetabox(array $metabox)
	{
		$fields = [];
		foreach ( $metabox['fields'] as $fieldGroup ) {

			$fields = array_merge($fields, $this->processFieldGroup($fieldGroup));
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