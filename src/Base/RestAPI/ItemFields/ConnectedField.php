<?php

/**
 * Adds connected/related fields to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;
use OWC\PDC\Base\Support\Traits\QueryHelpers;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use OWC\PDC\Base\Models\Item;
use OWC\PDC\Base\Models\PortalLinkGenerator;

/**
 * Adds connected/related fields to the output.
 */
class ConnectedField extends CreatesFields
{
    use CheckPluginActive;
    use QueryHelpers;

    /**
     * Sorting config for the connected fields
     *
     * @var array
     */
    protected $sorting = [];

    /**
     * Source for filtering the 'show_on' taxonomy
     */
    protected int $source = 0;

    /**
     * Creates an array of connected posts.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $connections = array_filter($this->plugin->config->get('p2p_connections.connections', []), function ($connection) {
            return in_array('pdc-item', $connection, true);
        });

        $result = [];

        foreach ($connections as $connection) {
            $type = $connection['from'] . '_to_' . $connection['to'];
            $result[$connection['to']] = $this->getConnectedItems($post->ID, $type, $this->extraQueryArgs($type));
        }

        return $result;
    }

    public function sorting(): array
    {
        return $this->sorting;
    }

    public function hasSorting(): bool
    {
        return ! empty($this->sorting);
    }

    public function setSorting(
        string $field,
        string $direction = ConnectedFieldSorter::DIRECTION_ASC,
        string $type = ConnectedFieldSorter::SORTING_TYPE_STRING
    ): self {
        $this->sorting = [$field, $direction, $type];

        return $this;
    }

    /**
     * Get connected items of a post, for a specific connection type.
     *
     * @param int    $postID
     * @param string $type
     *
     * @return array
     */
    protected function getConnectedItems(int $postID, string $type, array $extraQueryArgs = []): array
    {
        if (! function_exists('p2p_type')) {
            return [
                'error' => __('Posts 2 Posts plugin is not active', 'pdc-base'),
            ];
        }

        $connection = \p2p_type($type);

        if (! $connection) {
            return [
                /* translators: %s is replaced with a connection type */
                'error' => sprintf(__('Connection type "%s" does not exist', 'pdc-base'), $type),
            ];
        }

        $items = array_map(function (WP_Post $post) use ($type) {
			$data = [
				'id'          => $post->ID,
				'title'       => $post->post_title,
				'slug'        => $post->post_name,
				'excerpt'     => $post->post_excerpt,
				'date'        => $post->post_date,
				'language'    => get_post_meta($post->ID, '_owc_pdc-item-language', true) ?: 'nl',
			];

            if ($type === 'pdc-item_to_pdc-item') {
				$data['portal_url'] = PortalLinkGenerator::make(Item::makeFrom($post))->generateFullPortalLink();
                $data = $this->complementConnectedItem($post, $data);
            }

            return $data;
        }, $connection->get_connected($postID, $extraQueryArgs)->posts);

        if (! $this->hasSorting()) {
            return $items;
        }

        [$field, $direction, $type] = $this->sorting();

        try {
            $sorter = new ConnectedFieldSorter($items, $direction);

            return $sorter->setType($type)->sortByKey($field);
        } catch (InvalidSortingArgumentError $e) {
            return ['error' => $e->getMessage()];
        } catch (\Throwable $e) {
            return ['error' => __('Unable to apply connected sort', 'pdc-base')];
        }
    }

    /**
     * Add connected category and subcategory to connected pdc-item.
     */
    protected function complementConnectedItem(\WP_Post $post, array $data): array
    {
        $pdcItemCategoryConnection = \p2p_type('pdc-item_to_pdc-category');
        $pdcItemSubcategoryConnection = \p2p_type('pdc-item_to_pdc-subcategory');

        if ($pdcItemCategoryConnection) {
            $themes = array_map(function ($category) {
                return $category->post_name ?? '';
            }, $pdcItemCategoryConnection->get_connected($post->ID)->posts);

            $data['themes'] = array_filter($themes);
        }

        if ($pdcItemSubcategoryConnection) {
            $subthemes = array_map(function ($subcategory) {
                return $subcategory->post_name ?? '';
            }, $pdcItemSubcategoryConnection->get_connected($post->ID)->posts);

            $data['subthemes'] = array_filter($subthemes);
        }

        return $data;
    }

    protected function extraQueryArgs(string $type): array
    {
        $query = [];

        $connectionsExcludeInActive = $this->plugin->config->get('p2p_connections.connections_exclude_inactive', []);

        if (in_array($type, $connectionsExcludeInActive)) {
            $query = array_merge_recursive($query, $this->excludeInactiveItemsQuery());
        }

        if ($this->isPluginPDCInternalProductsActive()) {
            $connectionsExcludeInternal = $this->plugin->config->get('p2p_connections.connections_exclude_internal', []);

            if (in_array($type, $connectionsExcludeInternal)) {
                $query = array_merge_recursive($query, $this->excludeInternalItemsQuery());
            }
        }

        if ($this->shouldFilterSource()) {
            $query = array_merge_recursive($query, $this->filterShowOnTaxonomyQuery($this->source));
        }

        $query['connected_query'] = ['post_status' => ['publish', 'draft']];

        return $query;
    }

    public function setSource(int $source): self
    {
        $this->source = $source;

        return $this;
    }

    protected function shouldFilterSource(): bool
    {
        return 0 !== $this->source ;
    }
}
