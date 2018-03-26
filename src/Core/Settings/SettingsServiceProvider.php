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

	}

	/**
	 *
	 */
	public function registerSettingsPage()
	{

		$settings_pages[] = [
			'id'          => $this->prefix . 'pdc_base_settings',
			'option_name' => $this->prefix . 'pdc_base_settings',
			'menu_title'  => 'PDC instellingen pagina',
			'parent'      => '',
			'icon_url'    => 'dashicons-admin-settings',
			'position'    => 9
		];

		return $settings_pages;
	}

	/**
	 * register settings.
	 */
	public function registerSettings($rwmb_metaboxes)
	{


		$config_metaboxes = (array)apply_filters('owc/pdc_base/config/settings', $this->plugin->config->get('settings'));
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

		$metaboxes = apply_filters("owc/pdc_base/before_register_settings", $metaboxes);

		foreach ( $metaboxes as $metabox ) {
			$rwmb_metaboxes[] = $metabox;
		}

		return $rwmb_metaboxes;
	}
}