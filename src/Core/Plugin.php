<?php

namespace OWC_PDC_Base\Core;

use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Admin\Admin;

class Plugin extends BasePlugin
{

    /**
     * Name of the plugin.
     *
     * @var string
     */
    const NAME = 'pdc-base';

    /**
     * Version of the plugin.
     * Used for setting versions of enqueue scripts and styles.
     *
     * @var string
     */
    const VERSION = '0.1';

    /**
     * Boot the plugin.
     * Called on plugins_loaded event
     */
    public function boot()
    {
	    $this->config->setPluginName(self::NAME);
	    $this->config->setFilterExceptions(['core']);
	    $this->config->boot();

	    $this->bootServiceProviders();

	    if ( is_admin() ) {
	    	$admin = new Admin($this);
		    $admin->boot();
	    }

	    $this->loader->addAction( 'init', $this->config, 'filter', 4);
	    $this->loader->register();
    }

}