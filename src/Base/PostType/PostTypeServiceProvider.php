<?php

/**
 * Provider which handles the registration of posttype.
 */

namespace OWC\PDC\Base\PostType;

use OWC\PDC\Base\Foundation\ServiceProvider;

/**
 * Provider which handles the registration of posttype.
 */
class PostTypeServiceProvider extends ServiceProvider
{

    /**
     * Array of posttype definitions from the config.
     *
     * @var array $configPostTypes
     */
    protected $configPostTypes = [];

    /**
     * Register the hooks.
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addAction('init', $this, 'registerPostTypes');
    }

    /**
     * Register custom posttypes.
     */
    public function registerPostTypes()
    {
        if (function_exists('register_extended_post_type')) {
            $this->configPostTypes = $this->plugin->config->get('posttypes');

            foreach ($this->configPostTypes as $postTypeName => $postType) {
                if ('pdc-group' === $postTypeName && !$this->plugin->settings->useGroupLayer()) {
                    continue;
                }

                register_extended_post_type($postTypeName, $postType['args'], $postType['names']);
            }
        }
    }
}
