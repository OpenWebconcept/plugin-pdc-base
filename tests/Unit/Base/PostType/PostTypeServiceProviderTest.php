<?php

namespace OWC\PDC\Base\PostType;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class PostTypeServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        \WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_posttypes()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new PostTypeServiceProvider($plugin);

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'init',
            $service,
            'registerPostTypes'
        ])->once();

        /**
         * Examples of registering post types: http://johnbillion.com/extended-cpts/
         */
        $configPostTypes = [
            'posttype'        => [
                'args'  => [
                ],
                'names' => [
                ]
            ]
        ];

        $service->register();

        $this->assertTrue(true);
    }
}
