<?php

/**
 * Provider which add settings to the admin.
 */

namespace OWC\PDC\Base\Settings;

use OWC\PDC\Base\Metabox\MetaboxBaseServiceProvider;

/**
 * Provider which add settings to the admin.
 */
class SettingsServiceProvider extends MetaboxBaseServiceProvider
{
    /**
     * Registers the hooks
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addFilter('mb_settings_pages', $this, 'registerSettingsPage', 10, 1);
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerSettings', 10, 1);
    }

    /**
     * Registers the settings page, based on the config.
     *
     * @param array $rwmbSettingsPages
     *
     * @return array
     */
    public function registerSettingsPage($rwmbSettingsPages)
    {
        $settingsPages = $this->plugin->config->get('settings_pages');
        return array_merge($rwmbSettingsPages, $settingsPages);
    }

    /**
     * Register metaboxes for settings page
     *
     * @param $rwmbMetaboxes
     *
     * @return array
     */
    public function registerSettings($rwmbMetaboxes)
    {
        $configMetaboxes = $this->plugin->config->get('settings');
        $metaboxes       = [];

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, apply_filters("owc/pdc-base/before-register-settings", $metaboxes));
    }
}
