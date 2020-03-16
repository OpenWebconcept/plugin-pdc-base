<?php

/**
 * Abstract which handles the creation of fields.
 */

namespace OWC\PDC\Base\Support;

use WP_Post;
use OWC\PDC\Base\Foundation\Plugin;

/**
 * Abstract which handles the creation of fields.
 */

abstract class CreatesFields
{

    /**
     * Instance of the Plugin.
     *
     * @var Plugin $plugin
     */
    protected $plugin;

    /**
     * Construction of the abstract class.
     *
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Create an additional field on an array.
     *
     * @param WP_Post $post
     *
     * @return mixed
     */
    abstract public function create(WP_Post $post);

    /**
     * @param string $url
     * @return string
     */
    protected function getFileSize($url): string
    {
        if (!defined('WP_CONTENT_DIR')) {
            return '';
        }

        $projectRoot = str_replace('/wp-content', '', WP_CONTENT_DIR);
        $parsedUrl = wp_parse_url($url);

        if (empty($parsedUrl['path'])) {
            return '';
        }

        $path = $parsedUrl['path'];
        $file = $projectRoot . $path;

        return file_exists($file) ? filesize($projectRoot . $path) : '';
    }
}
