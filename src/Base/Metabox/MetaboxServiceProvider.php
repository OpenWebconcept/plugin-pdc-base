<?php

namespace OWC\PDC\Base\Metabox;

use OWC\PDC\Base\Support\Traits\RequestUPL;
use OWC\PDC\Base\Metabox\Handlers\UPLNameHandler;
use OWC\PDC\Base\Metabox\Handlers\UPLResourceHandler;

class MetaboxServiceProvider extends MetaboxBaseServiceProvider
{
    use RequestUPL;

    /**
     * Register the hooks.
     */
    public function register()
    {
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes', 10, 1);
        $this->plugin->loader->addAction('updated_post_meta', new UPLResourceHandler(), 'handleUpdatedMetaClassicEditor', 10, 4);
        $this->plugin->loader->addAction('rest_after_insert_pdc-item', new UPLResourceHandler(), 'handleUpdatedMetaGutenbergEditor', 10, 3);
    }

    public function registerMetaboxes(array $rwmbMetaboxes): array
    {
        $configMetaboxes = $this->plugin->config->get('metaboxes', []);
        $configMetaboxes = $this->addOptionsUPL($configMetaboxes);

        if ($this->plugin->settings->useIdentifications()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('identifications_metaboxes', []));
        }

        if ($this->plugin->settings->useIdentifications() && ! $this->plugin->settings->useCombinedIdentification()) {
            $configMetaboxes = $this->removeCombinedIdentification($configMetaboxes);
        }

        if ($this->plugin->settings->useEscapeElement()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('escape_element_metabox', []));
        }

        if ($this->plugin->settings->useShowOn()) {
            $configMetaboxes = $this->getShowOnMetabox($configMetaboxes);
        }

        if ($this->plugin->settings->useThemeTiles()) {
            $configMetaboxes = $this->getTilesMetabox($configMetaboxes);
        }

        if ($this->plugin->settings->useTableOfContents()) {
            $configMetaboxes = $this->getTableOfContentsMetabox($configMetaboxes);
        }

        if ($this->plugin->settings->useFeedbackForm()) {
            $configMetaboxes = $this->getFeedbackFormMetabox($configMetaboxes);
        }

        $metaboxes = [];

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, apply_filters('owc/pdc-base/before-register-metaboxes', $metaboxes));
    }

    /**
     * Add UPL options, from remote, to UPL metabox.
     */
    private function addOptionsUPL(array $configMetaboxes): array
    {
        $configMetaboxes['base']['fields']['government']['upl_name']['options'] = (new UPLNameHandler($this->getOptionsUPL()))->getOptions();

        return $configMetaboxes;
    }

    private function removeCombinedIdentification(array $configMetaboxes): array
    {
        $configMetaboxes['identifications']['fields'] = array_filter($configMetaboxes['identifications']['fields'], function ($field) {
            return $field !== 'digid_eherkenning-group';
        }, ARRAY_FILTER_USE_KEY);

        return $configMetaboxes;
    }

    protected function getShowOnMetabox(array $configMetaboxes): array
    {
        return array_merge($configMetaboxes, $this->plugin->config->get('show_on_metabox', []));
    }

    protected function getTilesMetabox(array $configMetaboxes): array
    {
        return array_merge($configMetaboxes, $this->plugin->config->get('theme_tiles_metabox', []));
    }

    protected function getTableOfContentsMetabox(array $configMetaboxes): array
    {
        return array_merge($configMetaboxes, $this->plugin->config->get('table_of_contents_metabox', []));
    }

    protected function getFeedbackFormMetabox(array $configMetaboxes): array
    {
        $feedbackFormMetabox = $this->plugin->config->get('hide_feedback_form_metabox', []);
        $metaboxKeys = ['base', 'pdc-category', 'pdc-subcategory'];

        return array_map(function ($key, $metabox) use ($metaboxKeys, $feedbackFormMetabox) {
            if (! in_array($key, $metaboxKeys)) {
                return $metabox;
            }

            $metabox['fields']['general'] = array_merge($metabox['fields']['general'], $feedbackFormMetabox);

            return $metabox;
        }, array_keys($configMetaboxes), $configMetaboxes);
    }
}
