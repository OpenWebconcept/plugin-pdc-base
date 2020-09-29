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
     * Include theme in the URL to the portal website
     *
     * @return string|null
     */
    public function themeInPortalURL(): ?string
    {
        return $this->settings['_owc_setting_include_theme_in_portal_url'] ?? null;
    }

    /**
     * Include subtheme in the URL to the portal website
     *
     * @return string|null
     */
    public function subthemeInPortalURL(): ?string
    {
        return $this->settings['_owc_setting_include_subtheme_in_portal_url'] ?? null;
    }

    /**
     * URL to the portal website
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
     * @return boolean
     */
    public function useGroupLayer(): bool
    {
        return $this->getPostTypeSetting('pdc-group') === '1';
    }

    /**
     * Get option value
     *
     * @param string $postTypeName
     * @return string|null
     */
    public function getPostTypeSetting($postTypeName): ?string
    {
        return get_option('_owc_pdc_base_settings')['_owc_setting_' . $postTypeName] ?? null;
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_portal_url'                       => '',
            '_owc_setting_portal_pdc_item_slug'             => '',
            '_owc_setting_include_theme_in_portal_url'      => 0,
            '_owc_setting_include_subtheme_in_portal_url'   => 0,
            '_owc_setting_pdc-group'                        => 0
        ];

        return new static(wp_parse_args(get_option('_owc_pdc_base_settings'), $defaultSettings));
    }
}
