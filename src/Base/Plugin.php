<?php

namespace OWC\PDC\Base;

use OWC\PDC\Base\Plugin\BasePlugin;
use OWC\PDC\Base\Admin\Admin;

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
    const VERSION = '1.1';

    /**
     * Boot the plugin.
     * Called on plugins_loaded event
     */
    public function boot()
    {
	    $this->config->setProtectedNodes(['core']);
	    $this->config->boot();

	    $this->bootServiceProviders();

	    if ( is_admin() ) {
	    	$admin = new Admin($this);
		    $admin->boot();
	    }

	    $this->loader->addAction( 'init', $this, 'filterPlugin', 4);

	    $this->loader->register();
    }

    public function filterPlugin() {
	    do_action('owc/'.self::NAME.'/plugin', $this );
    }

}