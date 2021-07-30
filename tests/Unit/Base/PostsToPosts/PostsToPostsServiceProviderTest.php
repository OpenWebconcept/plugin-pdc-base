<?php

namespace OWC\PDC\Base\PostsToPosts;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class PostsToPostsServiceProviderTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_pdc_item_slug'             => '',
                '_owc_setting_include_theme_in_portal_url'      => 0,
                '_owc_setting_include_subtheme_in_portal_url'   => 0,
                '_owc_setting_pdc-group'                        => 0,
                '_owc_setting_identifications'                  => 0
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_pdc_item_slug'             => '',
                '_owc_setting_include_theme_in_portal_url'      => 0,
                '_owc_setting_include_subtheme_in_portal_url'   => 0,
                '_owc_setting_pdc-group'                        => 0,
                '_owc_setting_identifications'                  => 0
            ]
        ]);

        \WP_Mock::userFunction('is_admin', [
            'return' => true
        ]);

        \WP_Mock::userFunction('sanitize_text_field');
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_PostsToPosts()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new PostsToPostsServiceProvider($plugin);

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'init',
            $service,
            'registerPostsToPostsConnections',
        ])->once();

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'init',
            $service,
            'extendPostsToPostsConnections',
        ])->once();

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'admin_enqueue_scripts',
            $service,
            'limitPostsToPostsConnections',
            10,
        ])->once();


        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'p2p_connectable_args',
            $service,
            'filterP2PConnectableArgs',
            10,
        ])->once();

        $service->register();

        $this->assertTrue(true);
    }

    /** @test */
    public function test_filter_p2p_connectable_args_method()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new PostsToPostsServiceProvider($plugin);

        $inputArgs                 = [];
        $inputArgs['orderby']      = 'date';
        $inputArgs['order']        = 'desc';
        $inputArgs['p2p:per_page'] = 10;

        $outputArgs                 = [];
        $outputArgs['orderby']      = 'title';
        $outputArgs['order']        = 'asc';
        $outputArgs['p2p:per_page'] = 25;

        $this->assertEquals($outputArgs, $service->filterP2PConnectableArgs($inputArgs));
    }

    /** @test */
    public function test_register_posts_to_posts_connections_method()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new PostsToPostsServiceProvider($plugin);

        \WP_Mock::userFunction(
            'p2p_register_connection_type',
            [
                'args'   => null,
                'times'  => '2',
                'return' => true,
            ]
        );

        $configPostTypesInfo = [
            'posttype1' =>
            [
                'id'    => 'posttype1',
                'title' => 'post1',
            ],
            'posttype2' =>
            [
                'id'    => 'posttype2',
                'title' => 'post2',
            ],
        ];

        $config->shouldReceive('get')->with('p2p_connections.posttypes_info')->once()->andReturn($configPostTypesInfo);

        $configConnections = [
            [
                'from'       => 'posttype1',
                'to'         => 'posttype2',
                'reciprocal' => true,
            ],
            [
                'from'       => 'posttype1',
                'to'         => 'posttype1',
                'reciprocal' => false,
            ],
        ];

        $config->shouldReceive('get')->with('p2p_connections.connections')->once()->andReturn($configConnections);

        $connectionDefaults = [
            'can_create_post'       => false,
            'reciprocal'            => true,
            'sortable'              => 'any',
            'cardinality'           => 'many-to-many',
            'duplicate_connections' => false,
        ];

        //test for filter being called
        \WP_Mock::expectFilter('owc/pdc-base/p2p-connection-defaults', $connectionDefaults);

        $connectionType1 = [
            'id'              => 'posttype1_to_posttype2',
            'from'            => 'posttype1',
            'to'              => 'posttype2',
            'sortable'        => 'any',
            'from_labels'     => [
                'column_title' => 'post2',
            ],
            'title'           => [
                'from' => 'Koppel met een post2',
                'to'   => 'Koppel met een post1',
            ],
            'can_create_post' => false,
            'reciprocal'      => true,
        ];

        $connectionType2 = [
            'id'              => 'posttype1_to_posttype1',
            'from'            => 'posttype1',
            'to'              => 'posttype1',
            'sortable'        => 'any',
            'from_labels'     => [
                'column_title' => 'post1',
            ],
            'title'           => [
                'from' => 'Koppel met een post1',
                'to'   => '',
            ],
            'can_create_post' => false,
            'reciprocal'      => false,
            'admin_box'       => 'from',
        ];

        \WP_Mock::expectFilter('owc/pdc-base/before-register-p2p-connection/posttype1/posttype2', $connectionType1);
        \WP_Mock::expectFilter('owc/pdc-base/before-register-p2p-connection/posttype1/posttype1', $connectionType2);

        $service->registerPostsToPostsConnections();

        $this->assertTrue(true);
    }
}
