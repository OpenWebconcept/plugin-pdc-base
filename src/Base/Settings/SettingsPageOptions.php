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
        $setting = $this->settings['_owc_setting_include_theme_in_portal_url'] ?? false;

        return boolval($setting);
    }

    /**
     * Include subtheme in the URL to the portal website.
     */
    public function subthemeInPortalURL(): bool
    {
        $setting = $this->settings['_owc_setting_include_subtheme_in_portal_url'] ?? false;

        return boolval($setting);
    }

    /**
     * Include ID in the URL to the portal website.
     */
    public function idInPortalURL(): bool
    {
        $setting = $this->settings['_owc_setting_include_id_in_portal_url'] ?? true;

        return boolval($setting);
    }

    /**
     * URL to the portal website.
     */
    public function getPortalURL(): ?string
    {
        return $this->settings['_owc_setting_portal_url'] ?? null;
    }

    public function getPortalItemSlug(): ?string
    {
        return $this->settings['_owc_setting_portal_pdc_item_slug'] ?? null;
    }

    public function isPortalSlugValid(): bool
    {
        return ! empty($this->getPortalURL()) && ! empty($this->getPortalItemSlug());
    }

    public function useIdentifications(): bool
    {
        $setting = $this->settings['_owc_setting_identifications'] ?? false;

        return boolval($setting);
    }

    public function useCombinedIdentification(): bool
    {
        $setting = $this->settings['_owc_setting_combined_identification'] ?? false;

        return boolval($setting);
    }

    public function useGroupLayer(): bool
    {
        $setting = $this->settings['_owc_setting_pdc-group'] ?? false;

        return boolval($setting);
    }

    /**
     * Use portal url in items endpoint.
     */
    public function usePortalURL(): bool
    {
        $setting = $this->settings['_owc_setting_use_portal_url'] ?? false;

        return boolval($setting);
    }

    /**
     * Use escape element value in items endpoint.
     */
    public function useEscapeElement(): bool
    {
        $setting = $this->settings['_owc_setting_use_escape_element'] ?? false;
        
        return boolval($setting);
    }

    public function useShowOn(): bool
    {
        $setting = $this->settings['_owc_setting_pdc_enable_show_on'] ?? false;

        return boolval($setting);
    }

    /**
     * URL used for retrieving UPL terms.
     */
    public function getURLTermsUPL(): string
    {
        return $this->settings['_owc_upl_terms_url'] ?? '';
    }

    /**
     * Use enrichment.
     */
    public function useEnrichment(): bool
    {
        $setting = $this->settings['_owc_setting_use_enrichment'] ?? false;

        return boolval($setting);
    }

    /**
     * URL used for retrieving enrichments from external api.
     */
    public function getEnrichmentURL(): string
    {
        return $this->settings['_owc_upl_enrichment_url'] ?? '';
    }

    /**
     * URL used for retrieving default enrichments from external api.
     */
    public function getDefaultEnrichmentURL(): string
    {
        return $this->settings['_owc_upl_default_enrichment_url'] ?? '';
    }

    /**
     * Push new versions to input facility when enabled.
     */
    public function enableInputFacility(): bool
    {
        $setting = $this->settings['_owc_upl_enrichment_enable_input_facility'] ?? false;

        return boolval($setting);
    }

    /**
     * Token is used for creating new versions of enrichments.
     */
    public function getInputFacilityApiToken(): string
    {
        return $this->settings['_owc_upl_enrichment_input_facility_api_token'] ?? '';
    }

    /**
     * Token is used for creating new versions of enrichments.
     */
    public function getInputFacilityBaseApiURL(): string
    {
        return $this->settings['_owc_upl_enrichment_input_facility_base_api_url'] ?? '';
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_portal_url'                         => '',
            '_owc_setting_portal_pdc_item_slug'               => '',
            '_owc_setting_include_theme_in_portal_url'        => 0,
            '_owc_setting_include_subtheme_in_portal_url'     => 0,
            '_owc_setting_include_id_in_portal_url'           => 1,
            '_owc_setting_pdc-group'                          => 0,
            '_owc_setting_use_portal_url'                     => 0,
            '_owc_setting_identifications'                    => 0,
            '_owc_setting_use_escape_element'                 => 0,
            '_owc_upl_terms_url'                              => '',
            '_owc_setting_use_enrichment'                     => 0,
            '_owc_upl_enrichment_url'                         => '',
            '_owc_upl_enrichment_enable_input_facility'       => 0,
            '_owc_upl_enrichment_input_facility_api_token'    => '',
            '_owc_upl_enrichment_input_facility_base_api_url' => ''
        ];

        return new static(wp_parse_args(get_option('_owc_pdc_base_settings'), $defaultSettings));
    }
}
