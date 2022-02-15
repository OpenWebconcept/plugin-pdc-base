<?php declare(strict_types=1);

namespace OWC\PDC\Base\Settings;

use OWC\PDC\Base\Tests\Unit\TestCase;

class SettingsPageOptionsTest extends TestCase
{
    /** @var SettingsPageOptions */
    private $settingsPageOptions;

    public function setUp(): void
    {
        \WP_Mock::setUp();

        $this->settingsPageOptions = new SettingsPageOptions([
            '_owc_setting_portal_url'                       => 'www.test.nl',
            '_owc_setting_portal_pdc_item_slug'             => 'direct/regelen',
            '_owc_setting_include_theme_in_portal_url'      => false,
            '_owc_setting_include_subtheme_in_portal_url'   => true,
            '_owc_setting_identifications'                  => true,
            '_owc_setting_use_escape_element'               => false,
            '_owc_setting_pdc-group' => true
        ]);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function do_not_use_emergency_button_setting(): void
    {
        $expectedResult = false;
        $result = $this->settingsPageOptions->useEscapeElement();

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_url_has_value(): void
    {
        $expectedResult = 'www.test.nl';
        $result = $this->settingsPageOptions->getPortalURL();

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_url_has_no_value(): void
    {
        $expectedResult = '';
        $result = $this->settingsPageOptions->getPortalURL();

        $this->assertNotEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_item_slug_has_value(): void
    {
        $expectedResult = 'direct/regelen';
        $result = $this->settingsPageOptions->getPortalItemSlug();

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_item_slug_has_no_value(): void
    {
        $expectedResult = '';
        $result = $this->settingsPageOptions->getPortalItemSlug();

        $this->assertNotEquals($expectedResult, $result);
    }

    /** @test */
    public function identifications_are_used(): void
    {
        $result = $this->settingsPageOptions->useIdentifications();

        $this->assertTrue($result);
    }

    /** @test */
    public function subtheme_in_portal_url_is_true(): void
    {
        $result = $this->settingsPageOptions->subthemeInPortalURL();

        $this->assertTrue( $result);
    }

    /** @test */
    public function theme_in_portal_url_is_false(): void
    {
        $result = $this->settingsPageOptions->themeInPortalURL();

        $this->assertFalse($result);
    }

    /** @test */
    public function use_group_layer(): void
    {
        \WP_Mock::userFunction('useGroupLayer', [
            'return' => true
        ]);

        $result = $this->settingsPageOptions->useGroupLayer();

        $this->assertTrue($result);
    }
}
