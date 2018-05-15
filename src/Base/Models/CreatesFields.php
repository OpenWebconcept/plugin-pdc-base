<?php

namespace OWC\PDC\Base\Models;

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
     * @param array $post
     *
     * @return array
     */
    abstract public function create(array $post);

}