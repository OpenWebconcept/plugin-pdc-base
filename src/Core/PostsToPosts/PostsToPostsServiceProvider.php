<?php

namespace OWC_PDC_Base\Core\PostsToPosts;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class PostsToPostsServiceProvider extends ServiceProvider
{

	/**
	 * @var array
	 */
	private $connectionDefaults = [
		'can_create_post'       => false,
		'reciprocal'            => true,
		'sortable'              => 'any',
		'cardinality'           => 'many-to-many',
		'duplicate_connections' => false
	];

	public function register()
	{

		$this->plugin->loader->addAction('init', $this, 'registerPostsToPostsConnections');
		$this->plugin->loader->addFilter('p2p_connectable_args', $this, 'filterP2PConnectableArgs', 10);
	}

	/**
	 * register P2P connections
	 */
	public function registerPostsToPostsConnections()
	{
		if ( function_exists('p2p_register_connection_type') ) {

			$posttypes_info          = apply_filters('owc/pdc_base/p2p_posttypes_info', $this->plugin->config->get('p2p_connections.posttypes_info'));
			$default_connection_args = apply_filters('owc/pdc_base/p2p_connection_defaults', $this->connectionDefaults);

			$connections             = apply_filters('owc/pdc_base/before_register_p2p_connections', $this->plugin->config->get('p2p_connections.connections'));

			foreach ( $connections as $connection_args ) {

				$args = array_merge($default_connection_args, $connection_args);

				$connection_type = [
					'id'              => $posttypes_info[ $connection_args['from'] ]['id'] . '_to_' . $posttypes_info[ $connection_args['to'] ]['id'],
					'from'            => $connection_args['from'],
					'to'              => $connection_args['to'],
					'sortable'        => $args['sortable'],
					'admin_column'    => 'any',
					'from_labels'     => [
						'column_title' => $posttypes_info[ $connection_args['to'] ]['title']
					],
					'title'           => [
						'from' => 'Koppel met een ' . $posttypes_info[ $connection_args['to'] ]['title'] . ' ',
						'to'   => 'Koppel met een ' . $posttypes_info[ $connection_args['from'] ]['title'] . ' '
					],
					'can_create_post' => $args['can_create_post'],
					'reciprocal'      => $args['reciprocal'],
				];

				if ( $connection_args['from'] == $connection_args['to'] ) {
					$connection_type['title']['to'] = '';
					$connection_type['admin_box']   = 'from';
				}

				$connection_type = apply_filters("owc/pdc_base/before_register_p2p_connection/{$posttypes_info[ $connection_args['from'] ]['id']}/{$posttypes_info[ $connection_args['to'] ]['id']}", $connection_type );

				p2p_register_connection_type($connection_type);
			}
		}
	}

	/*
	 * method for changing default P2P behaviour. Override by adding additional filter with higher priority (=larger number)
	 */
	public function filterP2PConnectableArgs($args)
	{
		$args['orderby']      = 'title';
		$args['order']        = 'asc';
		$args['p2p:per_page'] = 25;

		return $args;
	}
}