<?php

namespace OWC\PDC\Base\Models;

use OWC\PDC\Base\Models\Item;
use Mockery as m;
use OWC\PDC\Base\Models\PortalLinkGenerator;
use OWC\PDC\Base\Tests\Unit\TestCase;

class PortalLinkGeneratorTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                       => 'https://www.gouda.nl',
                '_owc_setting_portal_pdc_item_slug'             => 'direct/regelen',
                '_owc_setting_include_theme_in_portal_url'      => 1,
                '_owc_setting_include_subtheme_in_portal_url'   => 1,
                '_owc_setting_pdc-group'                        => 0,
                '_owc_setting_identifications'                  => 0
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => 'https://www.gouda.nl',
                '_owc_setting_portal_pdc_item_slug'             => 'direct/regelen',
                '_owc_setting_include_theme_in_portal_url'      => 1,
                '_owc_setting_include_subtheme_in_portal_url'   => 1,
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
    public function generate_base_portal_link(): void
    {
        $item = new Item([], []);
        $generator = PortalLinkGenerator::make($item);

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['https://www.gouda.nl'])
            ->once()
            ->andReturn('https://www.gouda.nl/');

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['direct/regelen'])
            ->once()
            ->andReturn('direct/regelen/');

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['thema'])
            ->once()
            ->andReturn('thema/');

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['subthema'])
            ->once()
            ->andReturn('subthema/');

        $expected = 'https://www.gouda.nl/direct/regelen/thema/subthema/';
        $result = $generator->generateBasePortalLink();

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function generate_full_portal_link(): void
    {
        $itemArgs = [
            'post_title' => 'Test',
            'post_name' => 'test'
        ];

        $item = new Item($itemArgs, []);
        $generator = PortalLinkGenerator::make($item);

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['https://www.gouda.nl'])
            ->once()
            ->andReturn('https://www.gouda.nl/');

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['direct/regelen'])
            ->once()
            ->andReturn('direct/regelen/');

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['thema'])
            ->once()
            ->andReturn('thema/');

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['subthema'])
            ->once()
            ->andReturn('subthema/');

        \WP_Mock::userFunction('trailingslashit')
            ->withArgs(['test'])
            ->once()
            ->andReturn('test/');

        $expected = 'https://www.gouda.nl/direct/regelen/thema/subthema/test/';
        $result = $generator->generateFullPortalLink();

        $this->assertEquals($expected, $result);
    }
}
