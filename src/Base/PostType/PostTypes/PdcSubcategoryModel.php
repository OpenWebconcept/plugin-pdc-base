<?php
/**
 * Model for the sub-category
 */

namespace OWC\PDC\Base\PostType\PostTypes;

/**
 * Model for the sub-category
 */
class PdcSubcategoryModel
{
    /**
     * Checks to see if related pdc-items to Subthema have type taxonomy term 'melding' selected
     *
     * @param $object
     * @param $fieldName
     * @param $request
     *
     * @return bool
     */
    public function hasReport($object, $fieldName, $request): bool
    {
        $hasReport = false;

        $queryArgs = [
            'post_type'        => 'pdc-item',
            'connected_type'   => 'pdc-item_to_pdc-subcategory',
            'posts_per_page'   => - 1,
            'post_status'      => 'publish',
            'suppress_filters' => false,
            'nopaging'         => true,
            'connected_items'  => $object['id'],
            'tax_query'        => [
                [
                    'taxonomy' => 'pdc-type',
                    'field'    => 'slug',
                    'terms'    => 'melding',
                ],
            ],
        ];

        $hasReportCheckQuery = new \WP_Query($queryArgs);

        if (0 != $hasReportCheckQuery->post_count) {
            $hasReport = true;
        }

        return apply_filters('owc/pdc-base/rest-api/pdcsubcategory/field/has-report', $hasReport, $object, $fieldName, $request);
    }

    /**
     * Checks to see if related pdc-items to Subthema have '_gb_pdc_afspraak_active' enabled
     *
     * @param $object
     * @param string $fieldName
     * @param $request
     *
     * @return bool
     */
    public function hasAppointment($object, $fieldName, $request): bool
    {
        $hasAppointment = false;

        $queryArgs = [
            'post_type'        => 'pdc-item',
            'connected_type'   => 'pdc-item_to_pdc-subcategory',
            'posts_per_page'   => - 1,
            'post_status'      => 'publish',
            'suppress_filters' => false,
            'nopaging'         => true,
            'connected_items'  => $object['id'],
            'meta_query'       => [
                [
                    'key'   => '_owc_pdc_afspraak_active',
                    'value' => 1,
                ],
            ]
        ];

        $hasAppointmentCheckQuery = new \WP_Query($queryArgs);

        if (0 != $hasAppointmentCheckQuery->post_count) {
            $hasAppointment = true;
        }

        wp_reset_postdata();

        return apply_filters('owc/pdc-base/rest-api/pdcsubcategory/field/has-appointment', $hasAppointment, $object, $fieldName, $request);
    }
}
