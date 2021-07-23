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
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerMetaboxes', 10, 1);
        $this->plugin->loader->addAction('updated_post_meta', new UPLResourceHandler(), 'handleUpdatedMeta', 10, 4);
    }

    public function registerMetaboxes(array $rwmbMetaboxes): array
    {
        $configMetaboxes = $this->plugin->config->get('metaboxes');
        $configMetaboxes = $this->addOptionsUPL($configMetaboxes);

        if ($this->plugin->settings->useIdentifications()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('identifications_metaboxes'));
        }

        if ($this->plugin->settings->useEscapeElement()) {
            $configMetaboxes = array_merge($configMetaboxes, $this->plugin->config->get('escape_element_metabox'));
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
    private function addOptionsUPL(array $configMetaboxes): array
    {
        $configMetaboxes['base']['fields']['government']['upl_name']['options'] = (new UPLNameHandler($this->getOptionsUPL()))->getOptions();

        return $configMetaboxes;
    }
}
