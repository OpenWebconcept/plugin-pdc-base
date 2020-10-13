<?php

namespace OWC\PDC\Base\RestAPI;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class RestAPIServiceProviderTest extends TestCase
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

        $this->config = m::mock(Config::class);
        $this->plugin = m::mock(Plugin::class);

        $this->plugin->config = $this->config;
        $this->plugin->loader = m::mock(Loader::class);

        $this->service = new RestAPIServiceProvider($this->plugin);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_rest_endpoints()
    {
        $this->plugin->loader->shouldReceive('addAction')->withArgs([
            'rest_api_init',
            $this->service,
            'registerRoutes'
        ])->once();

        $this->plugin->loader->shouldReceive('addFilter')->withArgs([
            'owc/config-expander/rest-api/whitelist',
            $this->service,
            'whitelist',
            10,
            1
        ])->once();

        $fields = [
            'items' => [
                'fields' => [
                    'taxonomies'        => OWC\PDC\Base\RestAPI\ItemFields\TaxonomyField::class,
                    'connected'         => OWC\PDC\Base\RestAPI\ItemFields\ConnectedField::class,
                    'image'             => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                    'appointment'       => OWC\PDC\Base\RestAPI\ItemFields\AppointmentField::class,
                    'forms'             => OWC\PDC\Base\RestAPI\ItemFields\FormsField::class,
                    'downloads'         => OWC\PDC\Base\RestAPI\ItemFields\DownloadsField::class,
                    'links'             => OWC\PDC\Base\RestAPI\ItemFields\LinksField::class,
                    'title_alternative' => OWC\PDC\Base\RestAPI\ItemFields\TitleAlternativeField::class,
                    'faq'               => OWC\PDC\Base\RestAPI\ItemFields\FAQField::class
                ]
            ]
        ];

        $this->config->shouldReceive('get')->with('api.models')->once()->andReturn($fields);
        $this->service->register();

        $this->assertTrue(true);
    }

    /** @test */
    public function it_whitelists_the_namespace_correctly()
    {
        $actual = $this->service->whitelist([
            'test/v1' => [
                'endpoint_stub' => 'test',
                'methods'       => ['GET', 'POST']
            ]
        ]);
        $expected = [
            'test/v1' => [
                'endpoint_stub' => 'test',
                'methods'       => ['GET', 'POST']
            ],
            'owc/pdc/v1' => [
                'endpoint_stub' => '/owc/pdc/v1',
                'methods'       => ['GET']
            ]
        ];

        $this->assertEquals($expected, $actual);
    }
}
