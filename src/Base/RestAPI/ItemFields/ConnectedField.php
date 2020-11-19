<?php

/**
 * Adds connected/related fields to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\RestAPI\Controllers\ItemController;
use OWC\PDC\Base\Settings\SettingsPageOptions;
use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds connected/related fields to the output.
 */
class ConnectedField extends CreatesFields
{

    /**
     * Creates an array of connected posts.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $connections = array_filter($this->plugin->config->get('p2p_connections.connections'), function ($connection) {
            return in_array('pdc-item', $connection, true);
        });

        $result = [];

        foreach ($connections as $connection) {
            $type                      = $connection['from'] . '_to_' . $connection['to'];
            $result[$connection['to']] = $this->getConnectedItems($post->ID, $type);
        }

        return $result;
    }

    /**
     * Get connected items of a post, for a specific connection type.
     *
     * @param int    $postID
     * @param string $type
     *
     * @return array
     */
    protected function getConnectedItems(int $postID, string $type): array
    {
        $connection = \p2p_type($type);

        if (!$connection) {
            return [
                'error' => sprintf(__('Connection type "%s" does not exist', 'pdc-base'), $type),
            ];
        }

        // get the connections whom needs to exclude inactive items
        $connectionsExcludeInActive = $this->plugin->config->get('p2p_connections.connections_exclude_in_active');

        // add meta query when connection needs to exclude inactive items
        $metaQuery = in_array($type, $connectionsExcludeInActive) ? ItemController::hideInactiveItem() : [];

        return array_map(function (WP_Post $post) {
            $data = [
                'id'      => $post->ID,
                'title'   => $post->post_title,
                'slug'    => $post->post_name,
                'excerpt' => $post->post_excerpt,
                'date'    => $post->post_date,
                'themes' => array_map(function($theme) {
                        return [
                            'id' => $theme->ID,
                            'title' => $theme->post_title,
                            'slug'    => $theme->post_name,
                            'excerpt' => $theme->post_excerpt,
                        ];
                    }, \p2p_type('pdc-item_to_pdc-category')->get_related( $post->ID )->posts ?? []),
                'subthemes' => array_map(function($subtheme) {
                        return [
                            'id' => $subtheme->ID,
                            'title' => $subtheme->post_title,
                            'slug'    => $subtheme->post_name,
                            'excerpt' => $subtheme->post_excerpt,
                        ];
                    }, \p2p_type('pdc-item_to_pdc-subcategory')->get_related( $post->ID )->posts ?? []),
            ];
            if (SettingsPageOptions::make()->useGroupLayer()) {
                $data['groups'] = array_map(function($group) {
                        return [
                            'id' => $group->ID,
                            'title' => $group->post_title,
                            'slug'    => $group->post_name,
                            'excerpt' => $group->post_excerpt,
                        ];
                    }, \p2p_type('pdc-item_to_pdc-group')->get_related( $post->ID )->posts ?? []);
            }
            return $data;
        }, $connection->get_related($postID, $metaQuery)->posts);
    }
}
