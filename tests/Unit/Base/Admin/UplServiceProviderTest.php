<?php

namespace OWC\PDC\Base\Admin;

use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class UplServiceProviderTest extends TestCase
{
    /** @var UPLServiceProvider */
    private $uplServiceProvider;

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

        \WP_Mock::userFunction('load_plugin_textdomain');
        $this->uplServiceProvider = new UPLServiceProvider(new Plugin(__DIR__));
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function class_exists(): void
    {
        $this->assertInstanceOf('OWC\PDC\Base\Admin\UplServiceProvider', $this->uplServiceProvider);
    }

    /**
     * @test
     * @dataProvider hookDataProvider
     **/
    public function it_includes_script(string $hook): void
    {
        global $post;
        $post                      = new \stdClass;
        $post->post_type           = 'pdc-item';

        \WP_Mock::userFunction('wp_enqueue_script', [
            'times' => 1,
        ]);

        \WP_Mock::userFunction('plugins_url', [
            'return' => 'something'
        ]);

        $this->uplServiceProvider->adminEnqueueScripts($hook);
        $this->assertConditionsMet();
    }

    public function hookDataProvider(): array
    {
        return [
            'post hook'      => ['post.php'],
            'post-new hook ' => ['post-new.php']
        ];
    }

    /** @test */
    public function it_does_not_include_script_if_hook_is_not_post_or_post_new(): void
    {
        \WP_Mock::userFunction('wp_enqueue_script', [
            'times' => 0,
        ]);

        $this->uplServiceProvider->adminEnqueueScripts('fake-hook');

        $this->assertConditionsMet();
    }
}
