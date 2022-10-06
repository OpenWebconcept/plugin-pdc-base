<?php

namespace OWC\PDC\Base\Metabox\Handlers;

use OWC\PDC\Base\Support\Traits\RequestUPL;

class UPLResourceHandler
{
    use RequestUPL;

    /**
     * Update resourceURL meta based on uplName meta.
     *
     * @param mixed $metaValue
     */
    public function handleUpdatedMeta(int $metaId, int $postID, string $metaKey, $metaValue): void
    {
        if (!$this->objectIsPDC($postID) || $metaKey !== '_owc_pdc_upl_naam') {
            return;
        }

        $uplName = get_post_meta($postID, '_owc_pdc_upl_naam', true);

        if (empty($uplName)) {
            return;
        }

        $options     = $this->getOptionsUPL();
        $resourceURL = $this->getResourceURL($options, $uplName);

        if (empty($resourceURL)) {
            return;
        }

        update_post_meta($postID, '_owc_pdc_upl_resource', $resourceURL);
    }

    /**
     * Based on the uplName fetch the resource URL from options.
     */
    protected function getResourceURL(array $options, string $uplName): string
    {
        $matches = array_filter($options, function ($option) use ($uplName) {
            return $option['UniformeProductnaam']['value'] === $uplName;
        });

        // Reset array keys.
        $matches = array_values($matches);

        return $this->getURLFromMatch($matches);
    }

    protected function getURLFromMatch(array $matches): string
    {
        if (empty($matches[0]['URI']['value'])) {
            return '';
        }

        return $matches[0]['URI']['value'];
    }

    public function objectIsPDC(int $postID): bool
    {
        $post = get_post($postID);

        if ($post->post_type !== 'pdc-item') {
            return false;
        }

        return true;
    }
}
