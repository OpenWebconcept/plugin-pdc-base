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
            $uplNames = get_post_meta($item->ID, '_owc_pdc_upl_naam', false);
            $uplNames = is_array($uplNames[0] ?? '') ? array_filter($uplNames[0]) : array_filter($uplNames);

            if (empty($uplNames)) {
                continue;
            }

            if (is_string($uplNames)) {
                $uplNames = [$uplNames];
            }

            $transformed = $this->handleUplNames($uplNames);

            if (empty($transformed)) {
                continue;
            }

            delete_post_meta($item->ID, '_owc_pdc_upl_naam');

            foreach ($transformed as $upl) {
                add_post_meta($item->ID, '_owc_pdc_upl_naam', strtolower($upl));
            }
        }
    }

    /**
     * Post meta should be in lowercase so let's fix this in advance.
     */
    protected function handleUplNames(array $uplNames)
    {
        $transformed = [];

        foreach ($uplNames as $uplName) {
            if (empty($uplName)) {
                continue;
            }

            $transformed[] = strtolower($uplName);
        }

        return $transformed;
    }

    protected function prepareItems(): void
    {
        $this->items = array_map(function ($item) {
            $uplNames = get_post_meta($item->ID, '_owc_pdc_upl_naam', false);
            $uplNames = is_array($uplNames[0] ?? '') ? array_filter($uplNames[0]) : array_filter($uplNames);

            $uplUrl  = get_post_meta($item->ID, '_owc_pdc_upl_resource', true);
            $doelgroepen = get_the_terms($item->ID, 'pdc-doelgroep');

            if (!is_array($doelgroepen)) {
                $doelgroepen = [];
            }

            return ['id' => $item->ID, 'title' => $item->post_title, 'uplNames' => !empty($uplNames) ? $uplNames : ['Geen waarde'], 'uplUrl' => !empty($uplUrl) ? $uplUrl : [''], 'editLink' => get_edit_post_link($item->ID), 'doelgroepen' => $this->prepareTerms($doelgroepen)];
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
