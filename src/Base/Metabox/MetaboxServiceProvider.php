<?php

/**
 * Provider which handles the metabox registration.
 */

namespace OWC\PDC\Base\Metabox;

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
     * @return array
     */
    public function registerMetaboxes($rwmbMetaboxes): array
    {
        $configMetaboxes = $this->plugin->config->get('metaboxes');

        if ($this->plugin->settings->useIdentifications()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('identifications_metaboxes'));
        }

        if ($this->plugin->settings->useEscapeElement()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('escape_element_metabox'));
        }

        $metaboxes = [];

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, apply_filters("owc/pdc-base/before-register-metaboxes", $metaboxes));
    }
}
