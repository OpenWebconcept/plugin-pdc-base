<?php
/**
 * Provider which add settings to the admin.
 */

namespace OWC\PDC\Base\Settings;

use OWC\PDC\Base\Foundation\ServiceProvider;
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
        $this->plugin->loader->addAction('admin_init', $this, 'getSettingsOption');
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
        $metaboxes = [];

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, apply_filters("owc/pdc-base/before-register-settings", $metaboxes));
    }

    /**
     * Get all the options of the setting page.
     *
     * @todo Implement better way of retrieving settings (used in InterfaceServiceProvider).
     *
     * @return void
     */
    public function getSettingsOption()
    {
        $defaultSettings = [
            '_owc_setting_portal_url'           => '',
            '_owc_setting_portal_pdc_item_slug' => ''
        ];

        $this->plugin->settings = wp_parse_args(get_option(self::PREFIX.'pdc_base_settings'), $defaultSettings);
    }
}
