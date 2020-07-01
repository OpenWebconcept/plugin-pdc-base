<?php

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Foundation\ServiceProvider;

/**
 * Provider which regsiters the admin interface.
 */
class UPLServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->plugin->loader->addAction('admin_enqueue_scripts', $this, 'adminEnqueueScripts', 10, 1);
        $this->addUplCommand();
    }

    public function adminEnqueueScripts($hook): void
    {
        global $post;
    
        if ('post-new.php' == $hook || 'post.php' == $hook) {
            if ('pdc-item' === $post->post_type) {
                wp_enqueue_script('populate-upl', $this->plugin->getPluginUrl() . '/js/index.js', ['jquery'], $this->plugin->getVersion(), true);
            }
        }
    }

    /**
     * Add Command: wp populate-empty-upl
     * Populates post meta of PDC item when empty or format existing ones
     */
    private function addUplCommand(): void
    {
        if (class_exists('WP_CLI')) {
            \WP_CLI::add_command('populate-empty-upl', function () {
                $query = new \WP_Query([
                'post_type'      => 'pdc-item',
                'posts_per_page' => '-1'
            ]);

                if (is_array($query->posts) && 0 < count($query->posts)) {
                    foreach ($query->posts as $post) {
                        $postID = $post->ID;
                        $naamUPL = get_post_meta($postID, '_owc_pdc_upl_naam', true);
                        $naamUresource = get_post_meta($postID, '_owc_pdc_upl_resource', true);

                        // only when both fields are empty
                        if (empty($naamUPL) && empty($naamUresource)) {
                            $postTitle = $post->post_title;
                            $postTitleReplaced = str_replace(' ', '-', $postTitle);
                            $resource = 'http://standaarden.overheid.nl/owms/terms/' . $postTitleReplaced;

                            // create or update post meta
                            update_post_meta($postID, '_owc_pdc_upl_naam', $postTitle);
                            update_post_meta($postID, '_owc_pdc_upl_resource', strtolower($resource));

                            \WP_CLI::success($postTitle . ': UPL values updated');
                        }

                        // if values exists -> format them
                        if (!empty($naamUPL) && !empty($naamUresource)) {
                            $naamUPL = str_replace('-', ' ', $naamUPL);
                            $naamUresource = str_replace(',', '', $naamUresource);
                            $naamUresource = str_replace(' ', '-', $naamUresource);

                            // update post meta
                            update_post_meta($postID, '_owc_pdc_upl_naam', $naamUPL);
                            update_post_meta($postID, '_owc_pdc_upl_resource', strtolower($naamUresource));

                            \WP_CLI::success($naamUPL . ': UPL values updated');
                        }
                    }
                } else {
                    \WP_CLI::error('No PDC items found');
                }
            });
        }
    }
}
