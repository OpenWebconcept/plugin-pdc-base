<?php

namespace OWC\PDC\Base\UPL;

class UPL
{
    public function __construct(array $items, array $options)
    {
        $this->items = $items;
        $this->uplOptions = $options;
    }

    protected function validateUPLNames(): void
    {
        foreach ($this->items as $item) {
            $uplName = get_post_meta($item->ID, '_owc_pdc_upl_naam', true);

            if (empty($uplName) || ctype_lower($uplName)) {
                continue;
            }

            $this->UPLNameToLowerCase($item, $uplName);
        }
    }

    /**
     * Update post meta when value is not in lowercase.
     * Post meta should be in lowercase so let's fix this in advance.
     */
    protected function UPLNameToLowerCase(\WP_Post $item, string $uplName): string
    {
        $result = update_post_meta($item->ID, '_owc_pdc_upl_naam', strtolower($uplName));

        if (!$result) {
            return $uplName;
        }

        return strtolower($uplName);
    }

    protected function prepareItems(): void
    {
        $this->items = array_map(function ($item) {
            $uplName = get_post_meta($item->ID, '_owc_pdc_upl_naam', true);
            $uplUrl  = get_post_meta($item->ID, '_owc_pdc_upl_resource', true);
            $doelgroepen = get_the_terms($item->ID, 'pdc-doelgroep');

            if (!is_array($doelgroepen)) {
                $doelgroepen = [];
            }

            return ['id' => $item->ID, 'title' => $item->post_title, 'uplName' => !empty($uplName) ? $uplName : 'Geen waarde', 'uplUrl' => !empty($uplUrl) ? $uplUrl : '', 'editLink' => get_edit_post_link($item->ID), 'doelgroepen' => $this->prepareTerms($doelgroepen)];
        }, $this->items);
    }

    protected function prepareTerms(array $terms = []): string
    {
        if (empty($terms)) {
            return 'Geen waarde';
        }

        $holder = [];

        foreach ($terms as $term) {
            if (empty($term->name)) {
                continue;
            }

            $holder[] = $term->name;
        }

        return implode(', ', $holder);
    }
}
