<?php

namespace OWC_PDC_Base\Core\PostType\PostTypes;

use OWC_PDC_Base\Core\Config;

class PdcSubcategory
{


	/*
	 * Checks to see if related pdc-items to Subthema have type taxonomy term 'melding' selected
	 */
	public static function has_report($object, $field_name, $request)
	{
		$has_report = false;

		$query_args = [
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

		$has_report_check_query = new \WP_Query($query_args);

		if ( $has_report_check_query->post_count != 0 ) {
			$has_report = true;
		}

		return $has_report;
	}

	/*
	 * Checks to see if related pdc-items to Subthema have '_gb_pdc_afspraak_active' enabled
	 */
	public static function has_appointment($object, $field_name, $request)
	{
		$has_appointment = false;

		$query_args = [
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

		$has_appointment_check_query = new \WP_Query($query_args);

		if ( $has_appointment_check_query->post_count != 0 ) {
			$has_appointment = true;
		}

		wp_reset_postdata();

		return $has_appointment;
	}

}