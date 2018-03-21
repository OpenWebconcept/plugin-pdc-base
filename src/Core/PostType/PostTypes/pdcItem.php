<?php

namespace OWC_PDC_Base\Core\PostType\PostTypes;

use OWC_PDC_Base\Core\Config;

class PdcItem
{


	/**
	 * Instance of the config.
	 *
	 * @var $config \OWC_PDC_Base\Core\Config
	 */
	protected $config;

	public function __construct( $config = '' )
	{
		if ( ! empty( $config ) && is_a( $config, 'OWC_PDC_Base\Core\Config' ) ) {
			$this->config = $config;
		}
	}

	/*
    * summarizes fields in output
    * @return array $terms
    */
	private function getTermsAsArray($object, $taxonomy_id = '')
	{
		$terms = wp_get_post_terms($object['id'], $taxonomy_id);

		if ( ! is_wp_error($terms) ) {

			$collected_terms = [];

			foreach ( $terms as $term ) {
				$collected_terms[] = ['ID' => $term->term_id, 'name' => $term->name, 'slug' => $term->slug];
			}
			$terms = $collected_terms;
		}

		return $terms;
	}

	function getConnectedItems($item, $args)
	{

		$defaults = [
			'p2p_key'            => '',
			'item_callback'      => '',
			'item_callback_args' => []
		];

		$args = wp_parse_args($args, $defaults);

		$output = [];

		if ( empty($args['p2p_key']) ) {

			$output['error'] = 'p2p_key can not be empty';

			return $output;
		}
		if ( false === p2p_type($args['p2p_key']) ) {

			$output['error'] = sprintf('p2p_key "%s" does not exist', $args['p2p_key']);

			return $output;
		}

		$p2p_items_name = $args['p2p_key'];

		$connected = p2p_type($p2p_items_name)->get_connected($item['id']);

		if ( ! empty($connected->posts) ) {

			foreach ( $connected->posts as $connected_item ) {

				$output[] = call_user_func($args['item_callback'], $connected_item, $args['item_callback_args']);
			}
		}

		return $output;
	}

	private function getPdcItemAsArray($item)
	{
		$output = [
			'ID'    => $item->ID,
			'slug'  => $item->post_name,
			'title' => $item->post_title,
		];

		return $output;
	}

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

	public static function get_forms($object, $field_name, $request)
	{
		$forms      = [];
		$meta_id    = '_owc_pdc_forms_group';
		$forms_data = get_post_meta($object['id'], $meta_id, $single = true);

		foreach ( $forms_data as $form_data ) {

			$title = '';
			$url   = '';

			if ( ! empty($form_data['pdc_forms_url']) ) {
				$url = esc_url($form_data['pdc_forms_url']);
			}

			//$url can be empty after cleaning up, no need to add forms without url's
			if ( empty($url) ) {
				continue;
			}

			if ( ! empty($form_data['pdc_forms_title']) ) {
				$title = esc_attr(strip_tags($form_data['pdc_forms_title']));
			}

			//$title can be empty after cleaning up, no need to add forms without title
			if ( empty($title) ) {
				continue;
			}

			$forms[] = [
				'title' => $title,
				'url'   => $url
			];
		}

		return $forms;
	}

	public static function get_downloads($object, $field_name, $request)
	{
		$downloads      = [];
		$meta_id        = '_owc_pdc_downloads_group';
		$downloads_data = get_post_meta($object['id'], $meta_id, $single = true);

		foreach ( $downloads_data as $download_data ) {

			$title = '';
			$url   = '';

			if ( ! empty($download_data['pdc_downloads_url']) ) {
				$url = esc_url($download_data['pdc_downloads_url']);
			}

			//$url can be empty after cleaning up, no need to add downloads without url's
			if ( empty($url) ) {
				continue;
			}

			if ( ! empty($download_data['pdc_downloads_title']) ) {
				$title = esc_attr(strip_tags($download_data['pdc_downloads_title']));
			}

			//$title can be empty after cleaning up, no need to add downloads without title
			if ( empty($title) ) {
				continue;
			}

			$downloads[] = [
				'title' => $title,
				'url'   => $url
			];

		}

		return $downloads;
	}

	public static function get_title_alternative($object, $field_name, $request)
	{

		$meta_id           = '_owc_pdc_titel_alternatief';
		$title_alternative = get_post_meta($object['id'], $meta_id, $single = true);
		$title_alternative = strip_tags($title_alternative);
		$title_alternative = preg_replace('#[\n\r]+#s', ' ', $title_alternative);

		return $title_alternative;
	}

	public static function get_appointment($object, $field_name, $request)
	{
		$appointment           = [];
		$appointment['active'] = false;

		$appointment_active = (int)get_post_meta($object['id'], '_owc_pdc_afspraak_active', $single = true);

		if ( $appointment_active === 1 ) {

			$appointment['title']  = '';
			$appointment['url']    = '';
			$appointment['meta']   = '';
			$appointment['active'] = true;

			$appointment_title = get_post_meta($object['id'], '_owc_pdc_afspraak_title', $single = true);
			if ( ! empty($appointment_title) ) {
				$appointment['title'] = esc_attr(strip_tags($appointment_title));
			}

			$appointment_url = get_post_meta($object['id'], '_owc_pdc_afspraak_url', $single = true);
			if ( ! empty($appointment_url) ) {
				$appointment['url'] = esc_url($appointment_url);
			}

			$appointment_meta = get_post_meta($object['id'], '_owc_pdc_afspraak_meta', $single = true);
			if ( ! empty($appointment_meta) ) {
				$appointment['meta'] = esc_attr($appointment_meta);
			}
		}

		return $appointment;
	}

	public static function get_featured_image($object, $field_name, $request)
	{

		$featured_img_data = [];

		if ( has_post_thumbnail($object['id']) ) {

			$featured_img_post = get_post($object['featured_media']);

			$featured_img_data['title']       = $featured_img_post->post_title;
			$featured_img_data['description'] = $featured_img_post->post_content;
			$featured_img_data['caption']     = $featured_img_post->post_excerpt;
			$featured_img_data['alt']         = get_post_meta($featured_img_post->ID, '_wp_attachment_image_alt', true);

			$featured_img_size = 'large';
			$featured_img      = wp_get_attachment_image($object['featured_media'], $featured_img_size);

			add_filter('wp_get_attachment_metadata', [
				'\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItem',
				'filterWpGetAttachmentMetadata'
			], 10, 5);
			$featured_img_metadata = wp_get_attachment_metadata($object['featured_media'], $unfiltered = false);
			unset($featured_img_metadata['image_meta']);

			$featured_img_data['rendered'] = $featured_img;
			$featured_img_data['metadata'] = $featured_img_metadata;
			$featured_img_data['sizes']    = wp_get_attachment_image_sizes($object['featured_media'], $featured_img_size, $featured_img_metadata);
			$featured_img_data['srcset']   = wp_get_attachment_image_srcset($object['featured_media'], $featured_img_size, $featured_img_metadata);
		}

		return $featured_img_data;
	}

	public static function filterWpGetAttachmentMetadata($data, $attachment_id)
	{
		/**
		 * removing filter, to prevent nesting of filter
		 */
		remove_filter('wp_get_attachment_metadata', [
			'\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItem',
			'filterWpGetAttachmentMetadata'
		], 10);

		if ( ! empty($data['sizes']) ) {
			foreach ( $data['sizes'] as $size => $size_data ) {

				$attachment_image_src          = wp_get_attachment_image_src($attachment_id, $size);
				$data['sizes'][ $size ]['url'] = $attachment_image_src[0];
			}
		}

		return $data;
	}

	public function get_taxonomies($object, $field_name, $request)
	{
		$taxonomies_result = [];

		$taxonomies = apply_filters('owc/pdc_base/config/taxonomies', $this->config->get('taxonomies'));

		foreach ( $taxonomies as $taxonomy_id => $value ) {
			$taxonomy_ids[] = $taxonomy_id;
		}

		$taxonomy_ids = apply_filters('owc/pdc_base/core/posttype/posttypes/pdc_item/get_taxonomies/taxonomy_ids', $taxonomy_ids);

		foreach ( $taxonomy_ids as $taxonomy_id ) {
			$taxonomies_result[ $taxonomy_id ] = $this->getTermsAsArray($object, $taxonomy_id);
		}

		return $taxonomies_result;
	}

	public function get_connections($object, $field_name, $request)
	{
		$output = [];

		$request_attributes = $request->get_attributes();
		$request_params     = $request->get_params();

		//check for usage in list of pdc_items via check for 'get_items' callback method.
		if ( 'get_item' == $request_attributes['callback'][1] || ! empty($request_params['slug']) ) {

			$connections = apply_filters('owc/pdc_base/config/p2p_connections', $this->config->get('p2p_connections.connections'));


//			foreach ( $connections as $connection ) {
//
//				if ( in_array('pdc-item', $connection) ) {
//
//				}
//
//				$connected_items_args = [
//					'p2p_key'       => $connection['from'].'_to_'.'pdc-item_to_pdc-item',
//					'item_callback' => [$this, 'getPdcItemAsArray'],
//				];
//			}

			$connected_items_args = [
				'p2p_key'       => 'pdc-item_to_pdc-item',
				'item_callback' => [$this, 'getPdcItemAsArray'],
			];
			$output['pdc-items']  = $this->getConnectedItems($object, $connected_items_args);

			$connected_items_args = [
				'p2p_key'       => 'pdc-item_to_pdc-category',
				'item_callback' => [$this, 'getPdcItemAsArray'],
			];
			$output['themas']     = $this->getConnectedItems($object, $connected_items_args);

			$connected_items_args = [
				'p2p_key'       => 'pdc-item_to_pdc-subcategory',
				'item_callback' => [$this, 'getPdcItemAsArray'],
			];
			$output['subthemas']  = $this->getConnectedItems($object, $connected_items_args);

		}

		return $output;
	}

}