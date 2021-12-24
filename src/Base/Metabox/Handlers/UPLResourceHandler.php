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

        $uplNames = get_post_meta($postID, '_owc_pdc_upl_naam', false);
        $uplNames = is_array($uplNames[0]) ? array_filter($uplNames[0]) : array_filter($uplNames);

        if (empty($uplNames)) {
            return;
        }

        $options = $this->getOptionsUPL();

        foreach ($uplNames as $uplName) {
            $resourceURLs[] = $this->getResourceURL($options, $uplName);
        }

        delete_post_meta($postID, '_owc_pdc_upl_resource');

        if (empty($resourceURLs)) {
            return;
        }

        foreach ($resourceURLs as $resourceURL) {
            add_post_meta($postID, '_owc_pdc_upl_resource', $resourceURL);
        }
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
