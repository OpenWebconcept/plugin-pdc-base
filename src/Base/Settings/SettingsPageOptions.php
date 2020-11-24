<?php

namespace OWC\PDC\Base\Settings;

class SettingsPageOptions
{
    /**
     * Settings defined on settings page
     *
     * @var array
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Include theme in the URL to the portal website.
     *
     * @return bool
     */
    public function themeInPortalURL(): bool
    {
        return $this->settings['_owc_setting_include_theme_in_portal_url'] ?? false;
    }

    /**
     * Include subtheme in the URL to the portal website.
     *
     * @return bool
     */
    public function subthemeInPortalURL(): bool
    {
        return $this->settings['_owc_setting_include_subtheme_in_portal_url'] ?? false;
    }

    /**
     * URL to the portal website.
     *
     * @return string|null
     */
    public function getPortalURL(): ?string
    {
        return $this->settings['_owc_setting_portal_url'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPortalItemSlug(): ?string
    {
        return $this->settings['_owc_setting_portal_pdc_item_slug'] ?? null;
    }

    /**
     * @return bool
     */
    public function useIdentifications(): ?bool
    {
        return $this->settings['_owc_setting_identifications'] ?? false;
    }

    /**
     * @return boolean
     */
    public function useGroupLayer(): bool
    {
        return get_option('_owc_pdc_base_settings')['_owc_setting_pdc-group'] ?? false;
    }

    /**
     * Use portal url in items endpoint.
     * 
     * @return boolean
     */
    public function usePortalURL(): bool
    {
        return get_option('_owc_pdc_base_settings')['_owc_setting_use_portal_url'] ?? false;
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_portal_url'                       => '',
            '_owc_setting_portal_pdc_item_slug'             => '',
            '_owc_setting_include_theme_in_portal_url'      => 0,
            '_owc_setting_include_subtheme_in_portal_url'   => 0,
            '_owc_setting_pdc-group'                        => 0,
            '_owc_setting_identifications'                  => 0
        ];

        return new static(wp_parse_args(get_option('_owc_pdc_base_settings'), $defaultSettings));
    }
}
