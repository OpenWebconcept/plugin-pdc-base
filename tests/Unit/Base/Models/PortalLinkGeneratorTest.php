<?php

namespace OWC\PDC\Base\Models;

use Mockery as m;
use OWC\PDC\Base\Tests\Unit\TestCase;

class PortalLinkGeneratorTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url' => 'https://www.gouda.nl',
                '_owc_setting_portal_pdc_item_slug' => 'direct/regelen',
                '_owc_setting_include_theme_in_portal_url' => 1,
                '_owc_setting_include_subtheme_in_portal_url' => 1,
                '_owc_setting_pdc-group' => 0,
                '_owc_setting_identifications' => 0
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url' => 'https://www.gouda.nl',
                '_owc_setting_portal_pdc_item_slug' => 'direct/regelen',
                '_owc_setting_include_theme_in_portal_url' => 1,
                '_owc_setting_include_subtheme_in_portal_url' => 1,
                '_owc_setting_pdc-group' => 0,
                '_owc_setting_identifications' => 0
            ]
        ]);

        \WP_Mock::userFunction('wp_http_validate_url', [
            'return' => 'https://www.gouda.nl'
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
        // $generator = PortalLinkGenerator::make($item);
        $generator = m::mock(PortalLinkGenerator::class);

        $generator->shouldReceive('generateBasePortalLink')->once()->andReturn('https://www.gouda.nl/direct/regelen/thema/subthema/');

        $expected = 'https://www.gouda.nl/direct/regelen/thema/subthema/';
        $result = $generator->generateBasePortalLink();

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function generate_full_portal_link(): void
    {
        $generator = m::mock(PortalLinkGenerator::class);

        $generator->shouldReceive('generateFullPortalLink')->once()->andReturn('https://www.gouda.nl/direct/regelen/thema/subthema/test/');

        $expected = 'https://www.gouda.nl/direct/regelen/thema/subthema/test/';
        $result = $generator->generateFullPortalLink();

        $this->assertEquals($expected, $result);
    }
}
