<?php

namespace OWC_PDC_Base\Core\PostType\PostTypes;

use OWC_PDC_Base\Core\Config;

class PdcItemModel
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
	private function getTermsAsArray($object, $taxonomyId = '')
	{
		$terms = wp_get_post_terms($object['id'], $taxonomyId);

		if ( ! is_wp_error($terms) ) {

			$collectedTerms = [];

			foreach ( $terms as $term ) {
				$collectedTerms[] = ['ID' => $term->term_id, 'name' => $term->name, 'slug' => $term->slug];
			}
			$terms = $collectedTerms;
		}

		return $terms;
	}

	public function getConnectedItems($item, $args)
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

			$output['error'] = sprintf(__('p2p_key "%s" does not exist', 'pdc-base'), $args['p2p_key']);

			return $output;
		}

		$p2pItemsName = $args['p2p_key'];

		$connected = p2p_type($p2pItemsName)->get_connected($item['id']);

		if ( ! empty($connected->posts) ) {

			foreach ( $connected->posts as $connectedItem ) {

				$output[] = call_user_func($args['item_callback'], $connectedItem, $args['item_callback_args']);
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

	/**
	 * Retrieves links metadata from object.
	 * Escapes output
	 *
	 * @param $object
	 * @param $fieldName
	 * @param $request
	 *
	 * @return array
	 */
	public function getLinks($object, $fieldName, $request): array
	{

		$links     = [];
		$metaId    = '_owc_pdc_links_group';
		$linksData = get_post_meta($object['id'], $metaId, true);

		foreach ( $linksData as $linkData ) {

			$title = '';
			$url   = '';

			if ( ! empty($linkData['pdc_links_url']) ) {
				$url = esc_url($linkData['pdc_links_url']);
			}

			//$url can be empty after cleaning up, no need to add links without url's
			if ( empty($url) ) {
				continue;
			}

			if ( ! empty($linkData['pdc_links_title']) ) {
				$title = esc_attr(strip_tags($linkData['pdc_links_title']));
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

		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_links', $links, $object, $fieldName, $request);
	}

	/**
	 * Retrieves forms metadata from object.
	 * Escapes output
	 *
	 * @param $object
	 * @param $fieldName
	 * @param $request
	 *
	 * @return array
	 */
	public static function getForms($object, $fieldName, $request): array
	{
		$forms     = [];
		$metaId    = '_owc_pdc_forms_group';
		$formsData = get_post_meta($object['id'], $metaId, true);

		foreach ( $formsData as $formData ) {

			$title = '';
			$url   = '';

			if ( ! empty($formData['pdc_forms_url']) ) {
				$url = esc_url($formData['pdc_forms_url']);
			}

			//$url can be empty after cleaning up, no need to add forms without url's
			if ( empty($url) ) {
				continue;
			}

			if ( ! empty($formData['pdc_forms_title']) ) {
				$title = esc_attr(strip_tags($formData['pdc_forms_title']));
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

		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_forms', $forms, $object, $fieldName, $request);
	}

	/**
	 * Retrieves downloads metadata from object.
	 * Escapes output
	 *
	 * @param $object
	 * @param $fieldName
	 * @param $request
	 *
	 * @return array
	 */
	public static function getDownloads($object, $fieldName, $request): array
	{
		$downloads     = [];
		$metaId        = '_owc_pdc_downloads_group';
		$downloadsData = get_post_meta($object['id'], $metaId, true);

		foreach ( $downloadsData as $downloadData ) {

			$title = '';
			$url   = '';

			if ( ! empty($downloadData['pdc_downloads_url']) ) {
				$url = esc_url($downloadData['pdc_downloads_url']);
			}

			//$url can be empty after cleaning up, no need to add downloads without url's
			if ( empty($url) ) {
				continue;
			}

			if ( ! empty($downloadData['pdc_downloads_title']) ) {
				$title = esc_attr(strip_tags($downloadData['pdc_downloads_title']));
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
		
		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_downloads', $downloads, $object, $fieldName, $request);
	}

	/**
	 * @param $object
	 * @param $fieldName
	 * @param $request
	 *
	 * @return string
	 */
	public function getTitleAlternative($object, $fieldName, $request): string
	{

		$metaId           = '_owc_pdc_titel_alternatief';
		$titleAlternative = get_post_meta($object['id'], $metaId, true);
		$titleAlternative = strip_tags($titleAlternative);
		$titleAlternative = preg_replace('#[\n\r]+#s', ' ', $titleAlternative);

		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_title_alternative', $titleAlternative, $object, $fieldName, $request);
	}

	/**
	 * @param $object
	 * @param $fieldName
	 * @param $request
	 *
	 * @return array
	 */
	public function getAppointment($object, $fieldName, $request): array
	{
		$appointment           = [];
		$appointment['active'] = false;

		$appointmentActive = (int)get_post_meta($object['id'], '_owc_pdc_afspraak_active', true);

		if ( $appointmentActive === 1 ) {

			$appointment['title']  = '';
			$appointment['url']    = '';
			$appointment['meta']   = '';
			$appointment['active'] = true;

			$appointmentTitle = get_post_meta($object['id'], '_owc_pdc_afspraak_title', true);
			if ( ! empty($appointmentTitle) ) {
				$appointment['title'] = esc_attr(strip_tags($appointmentTitle));
			}

			$appointmentUrl = get_post_meta($object['id'], '_owc_pdc_afspraak_url', true);
			if ( ! empty($appointmentUrl) ) {
				$appointment['url'] = esc_url($appointmentUrl);
			}

			$appointmentMeta = get_post_meta($object['id'], '_owc_pdc_afspraak_meta', true);
			if ( ! empty($appointmentMeta) ) {
				$appointment['meta'] = esc_attr($appointmentMeta);
			}
		}

		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_appointment', $appointment, $object, $fieldName, $request);
	}

	public function getFeaturedImage($object, $fieldName, $request): array
	{

		$featuredImgData = [];

		if ( has_post_thumbnail($object['id']) ) {

			$featuredImgPost = get_post($object['featured_media']);

			$featuredImgData['title']       = $featuredImgPost->post_title;
			$featuredImgData['description'] = $featuredImgPost->post_content;
			$featuredImgData['caption']     = $featuredImgPost->post_excerpt;
			$featuredImgData['alt']         = get_post_meta($featuredImgPost->ID, '_wp_attachment_image_alt', true);

			$featuredImgSize = 'large';
			$featuredImg     = wp_get_attachment_image($object['featured_media'], $featuredImgSize);

			add_filter('wp_get_attachment_metadata', [
				'\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel',
				'filterWpGetAttachmentMetadata'
			], 10, 5);
			$featuredImgMetadata = wp_get_attachment_metadata($object['featured_media'], $unfiltered = false);
			unset($featuredImgMetadata['image_meta']);

			$featuredImgData['rendered'] = $featuredImg;
			$featuredImgData['metadata'] = $featuredImgMetadata;
			$featuredImgData['sizes']    = wp_get_attachment_image_sizes($object['featured_media'], $featuredImgSize, $featuredImgMetadata);
			$featuredImgData['srcset']   = wp_get_attachment_image_srcset($object['featured_media'], $featuredImgSize, $featuredImgMetadata);
		}

		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_featured_image', $featuredImgData, $object, $fieldName, $request);
	}

	/**
	 * @param $data
	 * @param $attachmentId
	 *
	 * @return array
	 */
	public static function filterWpGetAttachmentMetadata($data, $attachmentId): array
	{
		/**
		 * removing filter, to prevent nesting of filter
		 */
		remove_filter('wp_get_attachment_metadata', [
			'\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel',
			'filterWpGetAttachmentMetadata'
		], 10);

		if ( ! empty($data['sizes']) ) {
			foreach ( $data['sizes'] as $size => $sizeData ) {

				$attachmentImageSrc            = wp_get_attachment_image_src($attachmentId, $size);
				$data['sizes'][ $size ]['url'] = $attachmentImageSrc[0];
			}
		}

		return $data;
	}

	/**
	 * @param $object
	 * @param $fieldName
	 * @param $request
	 *
	 * @return array
	 */
	public function getTaxonomies($object, $fieldName, $request): array
	{
		$taxonomiesResult = [];

		$taxonomies = apply_filters('owc/pdc_base/config/taxonomies', $this->config->get('taxonomies'));

		foreach ( $taxonomies as $taxonomyId => $value ) {
			$taxonomyIds[] = $taxonomyId;
		}

		$taxonomyIds = apply_filters('owc/pdc_base/core/posttype/posttypes/pdc_item/get_taxonomies/taxonomy_ids', $taxonomyIds, $object, $fieldName, $request);

		foreach ( $taxonomyIds as $taxonomyId ) {
			$taxonomiesResult[ $taxonomyId ] = $this->getTermsAsArray($object, $taxonomyId);
		}

		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_taxonomies', $taxonomiesResult, $object, $fieldName, $request);
	}

	/**
	 * @param $object
	 * @param $fieldName
	 * @param $request
	 *
	 * @return array
	 */
	public function getConnections($object, $fieldName, $request): array
	{
		$output = [];

		$requestAttributes = $request->get_attributes();
		$requestParams     = $request->get_params();

		//check for usage in list of pdc_items via check for 'get_items' callback method.
		if ( 'get_item' == $requestAttributes['callback'][1] || ! empty($requestParams['slug']) ) {

			$connections = apply_filters('owc/pdc_base/config/p2p_connections', $this->config->get('p2p_connections.connections'));

			foreach ( $connections as $connection ) {

				if ( in_array('pdc-item', $connection, $strict = true) ) {

					$connectedItemsArgs                       = [
						'p2p_key'       => $connection['from'] . '_to_' . $connection['to'],
						'item_callback' => [$this, 'getPdcItemAsArray'],
					];
					$output[ $connectedItemsArgs['p2p_key'] ] = $this->getConnectedItems($object, $connectedItemsArgs);
				}
			}
		}

		return apply_filters('owc/pdc_base/rest_api/pdcitem/field/get_connections', $output, $object, $fieldName, $request);
	}
}