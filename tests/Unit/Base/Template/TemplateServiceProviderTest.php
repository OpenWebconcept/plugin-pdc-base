<?php

namespace OWC\PDC\Base\Template;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class TemplateServiceProviderTest extends TestCase
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
                '_owc_setting_pdc-group'                        => 0
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_pdc_item_slug'             => '',
                '_owc_setting_include_theme_in_portal_url'      => 0,
                '_owc_setting_include_subtheme_in_portal_url'   => 0,
                '_owc_setting_pdc-group'                        => 0
            ]
        ]);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function check_template_redirect_action()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new TemplateServiceProvider($plugin);

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'template_redirect',
            $service,
            'redirectAllButAdmin',
            10
        ])->once();

        $service->register();

        $this->assertTrue(true);
    }

    /** @test */
    public function check_redirect_all_but_admin_method()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new TemplateServiceProvider($plugin);

        \WP_Mock::userFunction(
            'is_admin',
            [
                'args'   => null,
                'times'  => '1',
                'return' => false
            ]
        );

        \WP_Mock::userFunction(
            'wp_doing_ajax',
            [
                'args'   => null,
                'times'  => '1',
                'return' => false
            ]
        );

        \WP_Mock::userFunction(
            'is_feed',
            [
                'args'   => null,
                'times'  => '1',
                'return' => false
            ]
        );

        \WP_Mock::userFunction(
            'wp_redirect',
            [
                'args'   => 'https://www.openwebconcept.nl/',
                'times'  => '1',
                'return' => false
            ]
        );

        $service->redirectAllButAdmin();

        $this->assertTrue(true);
    }
}
