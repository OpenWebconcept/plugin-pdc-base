<?php

namespace OWC\PDC\Base\TinyMce;

use Mockery as m;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class TinyMceServiceProviderTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();

        \WP_Mock::userFunction('get_option', ['return' => []]);
        \WP_Mock::userFunction('wp_parse_args', ['return' => []]);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
        m::close();
    }

    /** @test */
    public function check_registration_of_hooks(): void
    {
        $plugin = m::mock(Plugin::class);
        $plugin->loader = m::mock(Loader::class);

        $service = new TinyMceServiceProvider($plugin);

        $plugin->loader->shouldReceive('addFilter')->withArgs(['tiny_mce_before_init', $service, 'filterIframeAttribs', 10, 2])->once();
        $plugin->loader->shouldReceive('addFilter')->withArgs(['mce_external_plugins', $service, 'addSelectionGuard'])->once();

        $service->register();

        $this->assertTrue(true);
    }

    /** @test */
    public function selection_guard_is_added_as_versioned_external_plugin(): void
    {
        $plugin = m::mock(Plugin::class);
        $plugin->shouldReceive('getPluginUrl')->andReturn('https://example.test/wp-content/plugins/pdc-base');
        $plugin->shouldReceive('getVersion')->andReturn('1.2.3');

        $service = new TinyMceServiceProvider($plugin);

        $this->assertSame([
            'existing' => 'https://example.test/existing.js',
            'owcselectionguard' => 'https://example.test/wp-content/plugins/pdc-base/js/editor-selection-guard.js?ver=1.2.3',
        ], $service->addSelectionGuard(['existing' => 'https://example.test/existing.js']));
    }
}
