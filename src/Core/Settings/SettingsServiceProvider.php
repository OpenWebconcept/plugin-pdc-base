<?php

namespace OWC_PDC_Base\Core\Settings;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{

	/**
	 * @var string
	 */
	private $prefix = '_owc_';

	public function register()
	{

		$this->plugin->loader->addFilter('mb_settings_pages', $this, 'registerSettingsPage');
		$this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerSettings', 10, 1);

		$this->plugin->settings = get_option( $this->prefix .'pdc_base_settings');
	}

	/**
	 *
	 */
	public function registerSettingsPage()
	{

		$settingsPages = (array) apply_filters('owc/pdc_base/config/settings_pages', $this->plugin->config->get('settings_pages'));

		return $settingsPages;
	}

	/**
	 * @param $rwmb_metaboxes
	 *
	 * @return array
	 */
	public function registerSettings($rwmb_metaboxes)
	{


		$configMetaboxes = (array)apply_filters('owc/pdc_base/config/settings', $this->plugin->config->get('settings'));
		$metaboxes        = [];

		foreach ( $configMetaboxes as $metabox ) {

			$fields = [];
			foreach ( $metabox['fields'] as $fieldGroup ) {

				foreach ( $fieldGroup as $field ) {

					if ( isset($field['id']) ) {
						$field['id'] = $this->prefix . $field['id'];
					}
					$fields[] = $field;
				}
			}
			$metabox['fields'] = $fields;
			$metaboxes[]       = $metabox;
		}

		$metaboxes = apply_filters("owc/pdc_base/before_register_settings", $metaboxes);

		foreach ( $metaboxes as $metabox ) {
			$rwmbMetaboxes[] = $metabox;
		}

		return $rwmbMetaboxes;
	}
}