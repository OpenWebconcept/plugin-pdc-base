<?php

namespace OWC\PDC\Base\PostType;

use OWC\PDC\Base\Foundation\ServiceProvider;

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
     */
    public function register(): void
    {
        $this->plugin->loader->addAction('init', $this, 'registerPostTypes');
        $this->plugin->loader->addFilter('parse_query', $this, 'languageAdminFilter');
    }

    /**
     * Register custom posttypes.
     */
    public function registerPostTypes(): void
    {
        if (! function_exists('register_extended_post_type')) {
            return;
        }

        $this->configPostTypes = $this->plugin->config->get('posttypes');

        foreach ($this->configPostTypes as $postTypeName => $postType) {
            if ('pdc-group' === $postTypeName && ! $this->plugin->settings->useGroupLayer()) {
                continue;
            }

            if('pdc-item' === $postTypeName && $this->plugin->settings->useEnrichment()){
                $postType = $this->addAdminFilterPDC($postType);
            }

            register_extended_post_type($postTypeName, $postType['args'], $postType['names']);
        }
    }

    protected function addAdminFilterPDC(array $postType): array
    {
        $postType['args']['admin_filters']['language'] = [
            'title' => __('All languages', 'pdc-base'),
            'meta_key' => '_owc_pdc-item-language',
            'options' => [
                'nl'    => __('Dutch', 'pdc-base'),
                'en'    => __('English', 'pdc-base'),
                'de'    => __('German', 'pdc-base'),
                'tr'    => __('Turkish', 'pdc-base'),
            ]
        ];

        return $postType;
    }

    /**
     * Add PDC-item admin filtering on language.
     */
    public function languageAdminFilter(\WP_Query $query): void
    {
        if(! is_admin()){
            return;
        }

        global $pagenow, $typenow;

        if($typenow !== 'pdc-item' || 'edit.php' !== $pagenow || empty($_GET['language'])){
            return;
        }

        // PDC-items with no language set does not have a meta row.
        $language = $_GET['language'] === 'nl' ? '' : $_GET['language'];

        if(! empty($language)){
            return;
        }

        $metaQuery = [
            [
                'key' => '_owc_pdc-item-language',
                'compare' => 'NOT EXISTS'
            ]
        ];

        $query->set('meta_query', $metaQuery);
        $query->query['language'] = '';
    }
}
