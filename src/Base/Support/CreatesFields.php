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

}