<?php

/**
 * Adds connected fields to item in API.
 */

namespace OWC\PDC\Base\RestAPI\SharedFields;

use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use OWC\PDC\Base\Support\Traits\QueryHelpers;
use WP_Post;

/**
 * Adds connected fields to item in API.
 */
class ItemsField extends ConnectedField
{
    use CheckPluginActive;
    use QueryHelpers;

	/**
	 * Language for filtering
	 */
	protected ?string $language = null;

    /**
     * Creates an array of connected posts.
     */
    public function create(WP_Post $post): array
    {
        $connectionType = 'pdc-item_to_' . $post->post_type;

        return $this->getConnectedItems($post->ID, $connectionType, $this->extraQueryArgs($connectionType));
    }

    protected function extraQueryArgs(string $type): array
    {
		$query = [
			'p2p:per_page' => -1
		];

		$query = array_merge_recursive($query, $this->excludeInactiveItemsQuery());

		if ($this->isPluginPDCInternalProductsActive()) {
            $query = array_merge_recursive($query, $this->excludeInternalItemsQuery());
        }

        if ($this->shouldFilterSource()) {
            $query = array_merge_recursive($query, $this->filterShowOnTaxonomyQuery($this->source));
        }

        if ($this->shouldFilterLanguage()) {
            $query = array_merge_recursive($query, $this->filterLanguageQuery($this->language));
        }

		$query['connected_query'] = [
            'post_status' => ['publish', 'draft'],
        ];

        return $query;
    }

	public function setLanguage(string $language): self
	{
		$this->language = $language;

		return $this;
	}

	protected function shouldFilterLanguage(): bool
	{
		return !empty($this->language);
	}
}
