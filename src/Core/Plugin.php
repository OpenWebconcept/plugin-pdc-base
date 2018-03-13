<?php

namespace OWC_PDC_Base\Core;

use OWC_PDC_Base\Core\Plugin\BasePlugin;

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
     */
    public function boot()
    {

    }

}