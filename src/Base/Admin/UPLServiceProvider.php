<?php

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Foundation\ServiceProvider;

/**
 * Provider which regsiters the admin interface.
 */
class UPLServiceProvider extends ServiceProvider
{
    /** @var string */
    const DESCRIPTION = 'Populates upl fields of pdc items automatically based on the title of the post.';

    public function register(): void
    {
        $this->plugin->loader->addAction('admin_enqueue_scripts', $this, 'adminEnqueueScripts', 10, 1);

        if (class_exists('WP_CLI')) {
            \WP_CLI::add_command('populate-empty-upl', [$this, 'uplCommand'], ['shortdesc' => self::DESCRIPTION]);
        }
    }

    public function adminEnqueueScripts(string $hook): void
    {
        if (!('post-new.php' === $hook || 'post.php' === $hook)) {
            return;
        }

        global $post;
        if ('pdc-item' === $post->post_type) {
            wp_enqueue_script('populate-upl', $this->plugin->getPluginUrl() . '/js/populate-upl.js', ['jquery'], $this->plugin->getVersion(), true);
        }
    }

    public function uplCommand(): void
    {
        $posts = $this->getPdcItems();

        if (empty($posts)) {
            \WP_CLI::error('No PDC items found');
            return;
        }

        foreach ($posts as $post) {
            $this->populateUplFields($post);
        }
    }

    private function getPdcitems(): array
    {
        $query = new \WP_Query([
            'post_type'      => 'pdc-item',
            'posts_per_page' => '-1'
        ]);

        return empty($query->posts) ? [] : $query->posts;
    }

    private function populateUplFields(\WP_Post $post): void
    {
        $uplName     = $this->getUplName($post);
        $uplResource = $this->getUplResource($post, $uplName);

        $this->updatePostMeta($post->ID, '_owc_pdc_upl_naam', $uplName);
        $this->updatePostMeta($post->ID, '_owc_pdc_upl_resource', $uplResource);
    }

    private function updatePostMeta(int $postId, string $metaKey, string $metaValue): void
    {
        $succes = update_post_meta($postId, $metaKey, $metaValue);

        if (boolval($succes)) {
            \WP_CLI::success('PostId: ' .  $postId .  ' Updated: ' . $metaKey . ' with value: ' . $metaValue);
        }
    }

    private function getUplName(\WP_Post $post): string
    {
        $uplName = get_post_meta($post->ID, '_owc_pdc_upl_naam', true);

        if (empty($uplName)) {
            $uplName = $post->post_title;
        }

        return $uplName;
    }

    private function getUplResource(\WP_Post $post, string $uplName): string
    {
        $uplResource      = get_post_meta($post->ID, '_owc_pdc_upl_resource', true);

        if (empty($uplResource)) {
            $uplNameFormat  = str_replace(' ', '-', $uplName);
            $uplResource    = 'http://standaarden.overheid.nl/owms/terms/' . $uplNameFormat;
        }

        $uplResource = str_replace([' ', ','], ['-', ''], $uplResource);
        $uplResource = strtolower($uplResource);

        return $uplResource;
    }
}
