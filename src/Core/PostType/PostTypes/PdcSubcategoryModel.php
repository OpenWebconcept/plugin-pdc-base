<?php

namespace OWC_PDC_Base\Core\PostType\PostTypes;

use OWC_PDC_Base\Core\Config;

class PdcSubcategoryModel
{
	/**
	 * Checks to see if related pdc-items to Subthema have type taxonomy term 'melding' selected
	 *
	 * @param $object
	 * @param $field_name
	 * @param $request
	 *
	 * @return bool
	 */
	public function hasReport($object, $field_name, $request): bool
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

		if ( $hasReportCheckQuery->post_count != 0 ) {
			$hasReport = true;
		}

		return apply_filters('owc/pdc_base/rest_api/pdcsubcategory/field/has_report', $hasReport, $object, $field_name, $request);
	}

	/**
	 * Checks to see if related pdc-items to Subthema have '_gb_pdc_afspraak_active' enabled
	 *
	 * @param $object
	 * @param $field_name
	 * @param $request
	 *
	 * @return bool
	 */
	public function hasAppointment($object, $field_name, $request): bool
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

		if ( $hasAppointmentCheckQuery->post_count != 0 ) {
			$hasAppointment = true;
		}

		wp_reset_postdata();

		return apply_filters('owc/pdc_base/rest_api/pdcsubcategory/field/has_report', $hasAppointment, $object, $field_name, $request);
	}

}