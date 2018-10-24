<?php
/**
 * Provider which registers the connected/posts-to-posts items.
 */

namespace OWC\PDC\Base\PostsToPosts;

use OWC\PDC\Base\Foundation\ServiceProvider;

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
        $this->plugin->loader->addAction('init', $this, 'registerPostsToPostsConnections');
        $this->plugin->loader->addFilter('p2p_connectable_args', $this, 'filterP2PConnectableArgs', 10);
    }

    /**
     * Register P2P connections
     *
     * @return void
     */
    public function registerPostsToPostsConnections()
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
                    'admin_column'    => 'any',
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
     * @return void
     */
    public function filterP2PConnectableArgs(array $args)
    {
        $args['orderby']      = 'title';
        $args['order']        = 'asc';
        $args['p2p:per_page'] = 25;

        return $args;
    }
}
