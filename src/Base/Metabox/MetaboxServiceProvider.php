<?php

namespace OWC\PDC\Base\Metabox;

use OWC\PDC\Base\Metabox\Handlers\UPLNameHandler;
use OWC\PDC\Base\Metabox\Handlers\UPLResourceHandler;
use OWC\PDC\Base\Support\Traits\RequestUPL;

class MetaboxServiceProvider extends MetaboxBaseServiceProvider
{
    use RequestUPL;

    /**
     * Register the hooks.
     */
    public function register(): void
    {
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes', 10, 1);
        $this->plugin->loader->addAction('updated_post_meta', new UPLResourceHandler(), 'handleUpdatedMetaClassicEditor', 10, 4);
        $this->plugin->loader->addAction('rest_after_insert_pdc-item', new UPLResourceHandler(), 'handleUpdatedMetaGutenbergEditor', 10, 3);
    }

    public function registerMetaboxes(array $rwmbMetaboxes): array
    {
        $configMetaboxes = $this->plugin->config->get('metaboxes');
        $configMetaboxes = $this->addOptionsUPL($configMetaboxes);

        if ($this->plugin->settings->useEnrichment()) {
            $configMetaboxes = $this->addEnrichmentMetaBoxes($configMetaboxes);
        }

        if ($this->plugin->settings->useIdentifications()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('identifications_metaboxes'));
        }

        if ($this->plugin->settings->useIdentifications() && ! $this->plugin->settings->useCombinedIdentification()) {
            $configMetaboxes = $this->removeCombinedIdentification($configMetaboxes);
        }

        if ($this->plugin->settings->useEscapeElement()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('escape_element_metabox'));
        }

        if ($this->plugin->settings->useShowOn()) {
            $configMetaboxes = $this->getShowOnMetabox($configMetaboxes);
        }

        $metaboxes = [];

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, apply_filters("owc/pdc-base/before-register-metaboxes", $metaboxes));
    }

    /**
     * Add UPL options, from remote, to UPL metabox.
     */
    protected function addOptionsUPL(array $configMetaboxes): array
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
        return array_merge($configMetaboxes, $this->plugin->config->get('show_on_metabox'));
    }

    protected function addEnrichmentMetaBoxes(array $configMetaboxes): array
    {
        $enrichmentsMetaboxes = $this->plugin->config->get('enrichment_metaboxes');

        if (! $this->plugin->settings->enableInputFacility()) {
            $enrichmentsMetaboxes['enrichment']['fields'] = $this->removeInputFacilityMetaboxes($enrichmentsMetaboxes['enrichment']['fields']);
        }

        return array_merge($configMetaboxes, $enrichmentsMetaboxes);
    }

    private function removeInputFacilityMetaboxes(array $enrichmentsFields)
    {
        $enrichmentsFields['enrichment-data'] = $this->removeFromEnrichmentData($enrichmentsFields);
        $enrichmentsFields['enrichment-language']['group']['fields']= $this->removeFromEnrichmentLanguage($enrichmentsFields);

        return $enrichmentsFields;
    }

    private function removeFromEnrichmentData(array $enrichmentsFields): array
    {
        $metaboxesToRemove = [
            'enrichment_send_data_to_sdg'
        ];

        return array_filter($enrichmentsFields['enrichment-data'], function ($metabox) use ($metaboxesToRemove) {
            if (empty($metabox['id'])) {
                return true;
            }

            return in_array($metabox['id'], $metaboxesToRemove) ? false : true;
        });
    }

    private function removeFromEnrichmentLanguage(array $enrichmentsFields): array
    {
        $metaboxesToRemove = [
            'enrichment_sdg_example_text_to_insert_api'
        ];

        return array_filter($enrichmentsFields['enrichment-language']['group']['fields'], function ($metabox) use ($metaboxesToRemove) {
            if (empty($metabox['id'])) {
                return true;
            }

            return in_array($metabox['id'], $metaboxesToRemove) ? false : true;
        });
    }
}
