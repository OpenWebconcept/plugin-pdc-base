<?php

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\Models\Item;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->plugin->loader->addFilter('post_type_link', $this, 'filterPostLink', 10, 4);
        $this->plugin->loader->addFilter('preview_post_link', $this, 'filterPreviewLink', 10, 2);
        $this->plugin->loader->addAction('rest_prepare_pdc-item', $this, 'filterPreviewInNewTabLink', 10, 2);
    }

    /**
     * Change the url for preview of published posts in the portal.
     */
    public function filterPostLink(string $link, \WP_Post $post, bool $leavename, $sample): string
    {
        if ($post->post_type !== 'pdc-item' || !$this->plugin->settings->isPortalSlugValid()) {
            return $link;
        }

        if ($this->plugin->settings->idInPortalURL()) {
            return sprintf('%s%s/%s', Item::makeFrom($post)->getBasePortalURL(), ($leavename ? '%postname%' : $post->post_name), $post->ID);
        }

        return sprintf('%s%s', Item::makeFrom($post)->getBasePortalURL(), ($leavename ? '%postname%' : $post->post_name));
    }

    /**
     * Change the url for preview of draft posts in the portal.
     */
    public function filterPreviewLink(string $link, \WP_Post $post): string
    {
        if ($post->post_type !== 'pdc-item' || !$this->plugin->settings->isPortalSlugValid()) {
            return $link;
        }

        return sprintf('%s%s', Item::makeFrom($post)->getPortalURL(), '?draft-preview=true');
    }

    /**
     * Change the url of "preview in new tab" button for preview in the portal.
     */
    public function filterPreviewInNewTabLink(\WP_REST_Response $response, \WP_Post $post): \WP_REST_Response
    {
        if ($post->post_status === 'publish' || !$this->plugin->settings->isPortalSlugValid()) {
            return $response;
        }

        $response->data['link'] = sprintf('%s%s', Item::makeFrom($post)->getPortalURL(), '?draft-preview=true');

        return $response;
    }
}
