<?php

/**
 * Provider which registers the admin interface.
 */

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Foundation\ServiceProvider;
use WP_Post;

class PostsToPostsServiceProvider extends ServiceProvider
{
    /**
     * Registers the hooks.
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addAction('admin_enqueue_scripts', $this, 'limitPostsToPostsConnections', 10, 1);
    }

    public function limitPostsToPostsConnections($hook)
    {
        global $post_type;

        if ($post_type == 'pdc-item' && 'edit.php' != $hook) {
            wp_enqueue_script('limit-item-theme-connection', $this->plugin->getPluginUrl() . '/js/limit-item-connections.js');
            /**
             * 
             * 
             * 
             * Andere connecties toepassen op basis van config waarde
             * 
             * 
             * 
             */
        }
    }
}
