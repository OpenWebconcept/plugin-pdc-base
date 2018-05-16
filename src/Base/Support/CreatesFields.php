<?php

namespace OWC\PDC\Base\Support;

use WP_Post;
use OWC\PDC\Base\Foundation\Plugin;

abstract class CreatesFields
{

    /**
     * Instance of the Plugin.
     */
    protected $plugin;

    /**
     * Makes sure that the plugin is .
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
     * @return array
     */
    abstract public function create(WP_Post $post): array;

}