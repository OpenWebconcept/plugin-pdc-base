<?php

namespace OWC\PDC\Base\Settings;

class SettingsPageOptions
{
    /**
     * Settings defined on settings page
     */
    private array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Include theme in the URL to the portal website.
     */
    public function themeInPortalURL(): bool
    {
        return $this->settings['_owc_setting_include_theme_in_portal_url'] ?? false;
    }

    /**
     * Include subtheme in the URL to the portal website.
     */
    public function subthemeInPortalURL(): bool
    {
        return $this->settings['_owc_setting_include_subtheme_in_portal_url'] ?? false;
    }

    /**
     * Include ID in the URL to the portal website.
     */
    public function idInPortalURL(): bool
    {
        return $this->settings['_owc_setting_include_id_in_portal_url'] ?? true;
    }

    /**
     * URL to the portal website.
     */
    public function getPortalURL(): ?string
    {
        return $this->settings['_owc_setting_portal_url'] ?? null;
    }

    /**
     * E.g. 'direct-regelen' or 'onderwerpen'.
     */
    public function getPortalItemSlug(): ?string
    {
        return $this->settings['_owc_setting_portal_pdc_item_slug'] ?? null;
    }

    public function isPortalSlugValid(): bool
    {
        return !empty($this->getPortalURL()) && !empty($this->getPortalItemSlug());
    }

    public function useIdentifications(): ?bool
    {
        return $this->settings['_owc_setting_identifications'] ?? false;
    }

    public function useGroupLayer(): bool
    {
        return $this->settings['_owc_setting_pdc-group'] ?? false;
    }

    /**
     * Use portal url in items endpoint.
     */
    public function usePortalURL(): bool
    {
        return $this->settings['_owc_setting_use_portal_url'] ?? false;
    }

    /**
     * Use escape element value in items endpoint.
     */
    public function useEscapeElement(): bool
    {
        return $this->settings['_owc_setting_use_escape_element'] ?? false;
    }

    /**
     * URL used for retrieving UPL terms.
     */
    public function getURLTermsUPL(): string
    {
        return $this->settings['_owc_upl_terms_url'] ?? '';
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_portal_url'                       => '',
            '_owc_setting_portal_pdc_item_slug'             => '',
            '_owc_setting_include_theme_in_portal_url'      => 0,
            '_owc_setting_include_subtheme_in_portal_url'   => 0,
            '_owc_setting_include_id_in_portal_url'         => 1,
            '_owc_setting_pdc-group'                        => 0,
            '_owc_setting_use_portal_url'                   => 0,
            '_owc_setting_identifications'                  => 0,
            '_owc_setting_use_escape_element'               => 0,
            '_owc_upl_terms_url'                            => ''
        ];

        return new static(wp_parse_args(get_option('_owc_pdc_base_settings'), $defaultSettings));
    }
}
