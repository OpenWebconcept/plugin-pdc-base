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

		//$this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerSettings');
	}

	/**
	 * register settings.
	 */
	public function registerSettings()
	{


	}
}