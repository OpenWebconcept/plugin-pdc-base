<?php

namespace OWC_PDC_Base\Core\Admin;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{

	public function register()
	{

		$this->plugin->loader->addFilter('admin_bar_menu', $this, 'filterAdminbarMenu', 999);
		$this->plugin->loader->addFilter('get_sample_permalink_html', $this, 'filterGetSamplePermalinkHtml', 10, 5);

		$this->plugin->loader->addAction('page_row_actions', $this, 'actionModifyPageRowActions', 999, 2);
	}

	/**
	 *
	 * Action to edit link to modify current 'PDC-item' with deeplink to corresponding Portal onderwerp
	 * href-node => http://gembur.dev/wp/wp-admin/post.php?post=74&amp;action=edit
	 *
	 * @param $wp_admin_bar
	 */
	function filterAdminbarMenu($wp_admin_bar)
	{
		$view_node = $wp_admin_bar->get_node('view');
		if ( ! empty($view_node) ) {

			global $post;

			if ( $post->post_type == 'pdc-item' ) {
				$portal_url       = esc_url(trailingslashit($this->plugin->settings['_owc_setting_portal_url']) . trailingslashit($this->plugin->settings['_owc_setting_portal_pdc_item_slug']) . $post->post_name);
				$view_node->href  = $portal_url;
				$view_node->title = 'Bekijk PDC item in portal';
				$wp_admin_bar->add_node($view_node);
			}
		}
	}

	function filterGetSamplePermalinkHtml($return, $post_id, $new_title, $new_slug, $post)
	{
		if ( 'pdc-item' == $post->post_type ) {
			$portal_url  = esc_url(trailingslashit($this->plugin->settings['_owc_setting_portal_url']) . trailingslashit($this->plugin->settings['_owc_setting_portal_pdc_item_slug']) . $post->post_name);
			$button_text = "Bekijk in Portal";
			$button_html = sprintf('<a href="%s" target="_blank"><button type="button" class="button button-small" aria-label="%s">%s</button></a>', $portal_url, $button_text, $button_text);
			$return      .= $button_html;
		}

		return $return;
	}

	/**
	 * Action to edit post row actions to modify current 'PDC-item' with deeplink to corresponding Portal onderwerp
	 *
	 * @param $actions
	 * @param $post
	 */
	function actionModifyPageRowActions($actions, $post)
	{
		if ( ! empty($actions['view']) && $post->post_type == 'pdc-item' ) {

			$portal_url = esc_url(trailingslashit($this->plugin->settings['_owc_setting_portal_url']) . trailingslashit($this->plugin->settings['_owc_setting_portal_pdc_item_slug']) . $post->post_name);

			$actions['view'] = sprintf(
				'<a href="%s" rel="bookmark" aria-label="%s">%s</a>',
				$portal_url,
				/* translators: %s: post title */
				esc_attr(sprintf(__('View &#8220;%s&#8221;'), $post->post_title)),
				__('Bekijken in Portal')
			);
		}

		return $actions;
	}

}