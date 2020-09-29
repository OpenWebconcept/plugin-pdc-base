<?php

/**
 * Provider which registers the admin interface.
 */

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Foundation\ServiceProvider;
use WP_Post;
use OWC\PDC\Base\Models\Item;

/**
 * Provider which registers the admin interface.
 */
class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Registers the hooks.
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addFilter('admin_bar_menu', $this, 'filterAdminbarMenu', 999);
        $this->plugin->loader->addFilter('get_sample_permalink_html', $this, 'filterGetSamplePermalinkHtml', 10, 5);
        $this->plugin->loader->addAction('page_row_actions', $this, 'actionModifyPageRowActions', 999, 2);
    }

    /**
     * Action to edit link to modify current 'PDC-item' with deeplink to corresponding Portal onderwerp
     *
     * @param $wpAdminBar
     *
     * @return void
     */
    public function filterAdminbarMenu($wpAdminBar)
    {
        $viewNode = $wpAdminBar->get_node('view');

        if (!empty($viewNode)) {
            global $post;

            $wpAdminBar->remove_node('view');

            if ('pdc-item' === get_post_type($post)) {
                $itemModel              = new Item($post->to_array());
                $portalUrl              = $itemModel->getPortalURL();
                $wpAdminBar->add_node([
                    'id'        => 'view-portal', // new id or else wp get the default node
                    'parent'    => false,
                    'href'      => $portalUrl,
                    'group'     => false,
                    'title'     => __('View PDC item in portal', 'pdc-base'),
                ]);
            }
        }
    }

    /**
     * Alters the preview permalink output.
     *
     * @param string $return
     * @param int $postId
     * @param string $newTitle
     * @param string $newSlug
     * @param WP_Post $post
     *
     * @return string
     */
    public function filterGetSamplePermalinkHtml($return, $postId, $newTitle, $newSlug, WP_Post $post)
    {
        if ('pdc-item' == $post->post_type) {
            $itemModel              = new Item($post->to_array());
            $portalUrl              = $itemModel->getPortalURL();
            $buttonText             = _x('View in Portal', 'preview button text', 'pdc-base');
            $buttonHtml             = sprintf('<a href="%s" target="_blank"><button type="button" class="button button-small" aria-label="%s">%s</button></a>', $portalUrl, $buttonText, $buttonText);
            $return .= $buttonHtml;
        }

        return $return;
    }

    /**
     * Action to edit post row actions to modify current 'PDC-item' with deeplink to corresponding Portal onderwerp.
     *
     * @param array $actions
     * @param WP_Post $post
     */
    public function actionModifyPageRowActions($actions, WP_Post $post)
    {
        if (!empty($actions['view']) && 'pdc-item' == $post->post_type) {
            $itemModel              = new Item($post->to_array());
            $portalUrl              = $itemModel->getPortalURL();
            $actions['view']        = sprintf(
                '<a href="%s" rel="bookmark" aria-label="%s">%s</a>',
                $portalUrl,
                /* translators: %s: post title */
                esc_attr(sprintf(__('View &#8220;%s&#8221;', 'pdc-base'), $itemModel->getTitle())),
                _x('View in Portal', 'Preview text in PDC list', 'pdc-base')
            );
        }
        return $actions;
    }
}
