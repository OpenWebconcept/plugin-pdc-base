<?php
/**
 * Provider which handles the metabox registration.
 */

namespace OWC\PDC\Base\Metabox;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\Metabox\MetaboxBaseServiceProvider;

/**
 * Provider which handles the metabox registration.
 */
class MetaboxServiceProvider extends MetaboxBaseServiceProvider
{

    /**
     * Register the hooks.
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes', 10, 1);
    }

    /**
     * Register metaboxes.
     *
     * @param array $rwmbMetaboxes
     *
     * @return void
     */
    public function registerMetaboxes($rwmbMetaboxes)
    {
        $configMetaboxes = $this->plugin->config->get('metaboxes');
        $metaboxes        = [];

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, apply_filters("owc/pdc-base/before-register-metaboxes", $metaboxes));
    }
}
