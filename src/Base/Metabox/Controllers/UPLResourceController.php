<?php

namespace OWC\PDC\Base\Metabox\Controllers;

use OWC\PDC\Base\Support\Traits\RequestUPL;

class UPLResourceController
{
    use RequestUPL;

    /**
     * Update resourceURL meta based on uplName meta.
     *
     * @param int $metaId
     * @param int $postID
     * @param string $metaKey
     * @param mixed $metaValue
     * 
     * @return void
     */
    public function handleUpdatedMeta($metaId, $postID, $metaKey, $metaValue): void
    {
        if (!$this->objectIsPDC($postID)) {
            return;
        }

        $uplName = get_post_meta($postID, '_owc_pdc_upl_naam', true);

        if (empty($uplName)) {
            return;
        }

        $options     = $this->getOptionsUPL();
        $resourceURL = $this->getResourceUPL($options, $uplName);

        if (empty($resourceURL)) {
            return;
        }

        update_post_meta($postID, '_owc_pdc_upl_resource', $resourceURL);
    }

    /**
     * Based on the uplName fetch the resource URL from options.
     *
     * @param array $options
     * @param string $uplName
     * 
     * @return string
     */
    public function getResourceUPL(array $options, string $uplName): string
    {
        $match = array_filter($options, function ($option) use ($uplName) {
            return $option['UniformeProductnaam']['value'] === $uplName;
        });

        // Reset array keys.
        $match = array_values($match);

        if (empty($match[0]['URI']['value'])) {
            return '';
        }

        return $match[0]['URI']['value'];
    }

    protected function objectIsPDC(int $postID): bool
    {
        $post = get_post($postID);

        if ($post->post_type !== 'pdc-item') {
            return false;
        }

        return true;
    }
}
