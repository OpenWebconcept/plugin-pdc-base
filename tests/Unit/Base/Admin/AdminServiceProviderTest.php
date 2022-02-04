<?php

namespace OWC\PDC\Base\Admin;

use Mockery as m;
use OWC\PDC\Base\Foundation\Config;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class AdminServiceProviderTest extends TestCase
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
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
        m::close();
    }

    /** @test */
    public function check_registration_of_interface_methods(): void
    {
        $config  = m::mock(Config::class);
        $plugin  = m::mock(Plugin::class);
        $service = m::mock(AdminServiceProvider::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new AdminServiceProvider($plugin);

        $query = m::mock(\WP_Query::class);

        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'preview_post_link',
            $service,
            'filterPreviewLink',
            10,
            2
        ])->once();

        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'post_type_link',
            $service,
            'filterPostLink',
            10,
            4
        ])->once();

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'rest_prepare_pdc-item',
            $service,
            'filterPreviewInNewTabLink',
            10,
            2
        ])->once();

        $service->register();

        $this->assertTrue(true);
    }
}
