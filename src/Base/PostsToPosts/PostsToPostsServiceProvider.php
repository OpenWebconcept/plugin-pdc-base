<?php

/**
 * Provider which registers the connected/posts-to-posts items.
 */

namespace OWC\PDC\Base\PostsToPosts;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\Settings\SettingsPageOptions;

/**
 * Provider which registers the connected/posts-to-posts items.
 */
class PostsToPostsServiceProvider extends ServiceProvider
{

    /**
     * Default connection arguments.
     *
     * @var array $connectionDefaults
     */
    private $connectionDefaults = [
        'can_create_post'       => false,
        'reciprocal'            => true,
        'sortable'              => 'any',
        'cardinality'           => 'many-to-many',
        'duplicate_connections' => false,
    ];

    /**
     * Registers the posts-to-posts connection.
     *
     * @return void
     */
    public function register()
    {
        if ($this->isPostRewriteRepublishCopy()) {
            return;
        }

        $this->plugin->loader->addAction('init', $this, 'extendPostsToPostsConnections');
        $this->plugin->loader->addAction('init', $this, 'registerPostsToPostsConnections');
        $this->plugin->loader->addAction('admin_enqueue_scripts', $this, 'limitPostsToPostsConnections', 10);
        $this->plugin->loader->addFilter('p2p_connectable_args', $this, 'filterP2PConnectableArgs', 10);
    }

    private function isPostRewriteRepublishCopy(): bool
    {
        if (!is_admin()) {
            return false;
        }

        $postID = sanitize_text_field($_GET['post'] ?? '');
        $action = sanitize_text_field($_GET['action'] ?? '');

        if (empty($postID) || empty($action) || 'edit' !== $action) {
            return false;
        }

        $rewriteRepublish         = get_post_meta($postID, '_dp_is_rewrite_republish_copy', true);
        $postIsRewritePublishCopy = filter_var($rewriteRepublish, FILTER_VALIDATE_BOOLEAN);

        return $postIsRewritePublishCopy;
    }

    /**
     * Extend the P2P connections config file when CPT pdc-groups is active
     *
     * @return void
     */
    public function extendPostsToPostsConnections(): void
    {
        if (!SettingsPageOptions::make()->useGroupLayer()) {
            return;
        }

        $groupConnections = [
            [
                'from'       => 'pdc-item',
                'to'         => 'pdc-group',
                'reciprocal' => true,
            ],
            [
                'from'       => 'pdc-subcategory',
                'to'         => 'pdc-group',
                'reciprocal' => true,
            ],
            [
                'from'       => 'pdc-category',
                'to'         => 'pdc-group',
                'reciprocal' => true,
            ],
        ];

        $this->plugin->config->set(['p2p_connections.connections' => array_merge($this->plugin->config->get('p2p_connections.connections'), $groupConnections)]);
    }

    /**
     * Register P2P connections
     *
     * @return void
     */
    public function registerPostsToPostsConnections(): void
    {
        if (function_exists('p2p_register_connection_type')) {
            $posttypesInfo         = $this->plugin->config->get('p2p_connections.posttypes_info');
            $defaultConnectionArgs = apply_filters('owc/pdc-base/p2p-connection-defaults', $this->connectionDefaults);
            $connections           = $this->plugin->config->get('p2p_connections.connections');

            foreach ($connections as $connectionArgs) {
                $args = array_merge($defaultConnectionArgs, $connectionArgs);

                $connectionType = [
                    'id'              => $posttypesInfo[$connectionArgs['from']]['id'] . '_to_' . $posttypesInfo[$connectionArgs['to']]['id'],
                    'from'            => $connectionArgs['from'],
                    'to'              => $connectionArgs['to'],
                    'sortable'        => $args['sortable'],
                    'from_labels'     => [
                        'column_title' => $posttypesInfo[$connectionArgs['to']]['title'],
                    ],
                    'title'           => [
                        'from' => 'Koppel met een ' . $posttypesInfo[$connectionArgs['to']]['title'],
                        'to'   => 'Koppel met een ' . $posttypesInfo[$connectionArgs['from']]['title'],
                    ],
                    'can_create_post' => $args['can_create_post'],
                    'reciprocal'      => $args['reciprocal'],
                ];

                if ($connectionArgs['from'] == $connectionArgs['to']) {
                    $connectionType['title']['to'] = '';
                    $connectionType['admin_box']   = 'from';
                }

                $connectionType = apply_filters("owc/pdc-base/before-register-p2p-connection/{$posttypesInfo[$connectionArgs['from']]['id']}/{$posttypesInfo[$connectionArgs['to']]['id']}", $connectionType);

                p2p_register_connection_type($connectionType);
            }
        }
    }

    /**
     * Method for changing default P2P behaviour. Override by adding additional filter with higher priority (=larger number).
     *
     * @param array $args
     *
     * @return array
     */
    public function filterP2PConnectableArgs(array $args): array
    {
        $args['orderby']      = 'title';
        $args['order']        = 'asc';
        $args['p2p:per_page'] = 25;

        return $args;
    }

    /**
     * Limit the PostToPost connections inside of the editor for specific posttypes
     *
     * @param string $hook
     * @return void
     */
    public function limitPostsToPostsConnections(string $hook): void
    {
        global $post_type;

        if ('pdc-item' == $post_type && 'edit.php' != $hook) {
            wp_enqueue_script('limit-item-theme-connection', $this->plugin->getPluginUrl() . '/js/limit-item-connections.js', [], false, true);
        }

        if ('pdc-subcategory' == $post_type && 'edit.php' != $hook) {
            wp_enqueue_script('limit-subtheme-theme-connection', $this->plugin->getPluginUrl() . '/js/limit-subtheme-connections.js');
        }

        if ('pdc-group' == $post_type && 'edit.php' != $hook) {
            wp_enqueue_script('limit-group-subtheme-connection', $this->plugin->getPluginUrl() . '/js/limit-group-connections.js');
        }
    }
}
