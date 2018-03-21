<?php

namespace OWC_PDC_Base\Core\PostType\PostTypes;

class PdcItem
{

	public static function get_links($object, $field_name, $request)
	{

		$links      = [];
		$meta_id    = '_owc_pdc_links_group';
		$links_data = get_post_meta($object['id'], $meta_id, $single = true);

		foreach ( $links_data as $link_data ) {

			$title = '';
			$url   = '';

			if ( ! empty($link_data['pdc_links_url']) ) {
				$url = esc_url($link_data['pdc_links_url']);
			}

			//$url can be empty after cleaning up, no need to add links without url's
			if ( empty($url) ) {
				continue;
			}

			if ( ! empty($link_data['pdc_links_title']) ) {
				$title = esc_attr(strip_tags($link_data['pdc_links_title']));
			}

			//$title can be empty after cleaning up, no need to add links without title
			if ( empty($title) ) {
				continue;
			}

			$links[] = [
				'title' => $title,
				'url'   => $url
			];
		}

		return $links;
	}
}