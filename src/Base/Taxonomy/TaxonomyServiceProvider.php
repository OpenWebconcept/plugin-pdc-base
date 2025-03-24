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
     * @var array
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

        if ($this->plugin->settings->useShowOn()) {
            $this->showOnFormFields();
        }
    }

    /**
     * Add elements to the taxonomy form.
     *
     * @return void
     */
    protected function showOnFormFields()
    {
        $this->plugin->loader->addAction('pdc-show-on_add_form_fields', TaxonomyController::class, 'addShowOnExplanation');
    }

    /**
     * Register custom taxonomies via extended_cpts
     *
     * @return void
     */
    public function registerTaxonomies()
    {
        if (! function_exists('register_extended_taxonomy')) {
            return;
        }

        $this->configTaxonomies = $this->filterConfigTaxonomies();

        foreach ($this->configTaxonomies as $taxonomyName => $taxonomy) {
            $taxonomy = apply_filters('owc/pdc-base/before-register-extended-taxonomy', $taxonomy, $taxonomyName);

            // Examples of registering taxonomies: https://github.com/johnbillion/extended-cpts/wiki
            \register_extended_taxonomy($taxonomyName, $taxonomy['object_types'], $taxonomy['args'], $taxonomy['names']);
        }
    }

    /**
     * Filter taxonomies based on plugin settings.
     *
     * @return array
     */
    protected function filterConfigTaxonomies(): array
    {
        if ($this->plugin->settings->useShowOn()) {
            return $this->plugin->config->get('taxonomies', []);
        }

        return array_filter($this->plugin->config->get('taxonomies', []), function ($taxonomyKey) {
            return ('pdc-show-on' !== $taxonomyKey);
        }, ARRAY_FILTER_USE_KEY);
    }
}
