<?php

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Plugin\ServiceProvider;

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
	 * @param $wpAdminBar
	 */
	public function filterAdminbarMenu($wpAdminBar)
	{
		$viewNode = $wpAdminBar->get_node('view');
		if ( ! empty($viewNode) ) {

			global $post;

			if ( get_post_type($post) === 'pdc-item' ) {
				$portalUrl       = esc_url(trailingslashit($this->plugin->settings['_owc_setting_portal_url']) . trailingslashit($this->plugin->settings['_owc_setting_portal_pdc_item_slug']) . $post->post_name);
				$viewNode->href  = $portalUrl;
				$viewNode->title = __('View PDC item in portal', 'pdc-base');
				$wpAdminBar->add_node($viewNode);
			}
		}
	}

	public function filterGetSamplePermalinkHtml($return, $postId, $newTitle, $newSlug, $post)
	{
		if ( 'pdc-item' == $post->post_type ) {
			$portalUrl  = esc_url(trailingslashit($this->plugin->settings['_owc_setting_portal_url']) . trailingslashit($this->plugin->settings['_owc_setting_portal_pdc_item_slug']) . $post->post_name);
			$buttonText = _x('View in Portal', 'preview button text', 'pdc-base');
			$buttonHtml = sprintf('<a href="%s" target="_blank"><button type="button" class="button button-small" aria-label="%s">%s</button></a>', $portalUrl, $buttonText, $buttonText);
			$return      .= $buttonHtml;
		}

		return $return;
	}

	/**
	 * Action to edit post row actions to modify current 'PDC-item' with deeplink to corresponding Portal onderwerp
	 *
	 * @param $actions
	 * @param $post
	 */
	public function actionModifyPageRowActions($actions, $post)
	{
		if ( ! empty($actions['view']) && $post->post_type == 'pdc-item' ) {

			$portalUrl = esc_url(trailingslashit($this->plugin->settings['_owc_setting_portal_url']) . trailingslashit($this->plugin->settings['_owc_setting_portal_pdc_item_slug']) . $post->post_name);

			$actions['view'] = sprintf(
				'<a href="%s" rel="bookmark" aria-label="%s">%s</a>',
				$portalUrl,
				/* translators: %s: post title */
				esc_attr(sprintf(__('View &#8220;%s&#8221;', 'pdc-base'), $post->post_title)),
				_x('View in Portal', 'Preview text in PDC list', 'pdc-base')
			);
		}

		return $actions;
	}

}