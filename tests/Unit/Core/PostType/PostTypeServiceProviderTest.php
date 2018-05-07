<?php

namespace OWC\PDC\Base\PostType;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Plugin\BasePlugin;
use OWC\PDC\Base\Plugin\Loader;
use OWC\PDC\Base\Tests\Unit\TestCase;

class PostTypeServiceProviderTest extends TestCase
{

	public function setUp()
	{
		\WP_Mock::setUp();
	}

	public function tearDown()
	{
		\WP_Mock::tearDown();
	}

	/** @test */
	public function check_registration_of_posttypes()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

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
