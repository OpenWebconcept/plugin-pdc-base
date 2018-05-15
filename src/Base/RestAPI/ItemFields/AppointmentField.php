<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Models\CreatesFields;

class AppointmentField extends CreatesFields
{

    /**
     * Create the appointment field for a given post.
     *
     * @param array $post
     *
     * @return array
     */
    public function create(array $post)
    {
        $active = isset($post['meta']['_owc_pdc_afspraak_active']) ? (bool) $post['meta']['_owc_pdc_afspraak_active'][0] : false;

        if ( ! $active) {
            return [
                'active' => false
            ];
        }

        return [
            'active' => true,
            'title'  => esc_attr(strip_tags($post['meta']['_owc_pdc_afspraak_title'][0] ?? '')),
            'url'    => esc_url($post['meta']['_owc_pdc_afspraak_url'][0] ?? ''),
            'meta'   => esc_attr($post['meta']['_owc_pdc_afspraak_meta'][0] ?? ''),
        ];
    }
}