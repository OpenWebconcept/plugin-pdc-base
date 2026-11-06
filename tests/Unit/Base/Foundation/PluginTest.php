<?php

namespace OWC\PDC\Base\Foundation;

use OWC\PDC\Base\Tests\Unit\TestCase;

class PluginTest extends TestCase
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
    }

    /** @test */
    public function version_is_read_once_from_the_plugin_header(): void
    {
        \WP_Mock::userFunction('get_file_data', [
            'args' => ['/plugins/pdc-base/pdc-base.php', ['Version' => 'Version']],
            'times' => 1,
            'return' => ['Version' => '1.2.3'],
        ]);

        $plugin = new Plugin('/plugins/pdc-base');

        $this->assertSame('1.2.3', $plugin->getVersion());
        $this->assertSame('1.2.3', $plugin->getVersion());
    }
}
