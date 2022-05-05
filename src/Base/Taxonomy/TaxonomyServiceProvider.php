<?php
/**
 * Provider which handles the registration of the taxonomies.
 */
namespace OWC\PDC\Base\Taxonomy;

use OWC\PDC\Base\Foundation\ServiceProvider;

/**
 * Provider which handles the registration of the taxonomies.
 */
class TaxonomyServiceProvider extends ServiceProvider
{

    /**
     * The array of taxonomies definitions from the config
     *
     * @var array $configTaxonomies
     */
    protected $configTaxonomies = [];

    /**
     * Register the hooks
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addAction('init', $this, 'registerTaxonomies');
    }

    /**
     * Register custom taxonomies via extended_cpts
     *
     * @return void
     */
    public function registerTaxonomies()
    {
        if (function_exists('register_extended_taxonomy')) {
            $this->configTaxonomies = $this->plugin->config->get('taxonomies');
            foreach ($this->configTaxonomies as $taxonomyName => $taxonomy) {
                // Examples of registering taxonomies: https://github.com/johnbillion/extended-cpts/wiki
                \register_extended_taxonomy($taxonomyName, $taxonomy['object_types'], $taxonomy['args'], $taxonomy['names']);
            }
        }
    }
}
