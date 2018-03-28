<?php

namespace OWC_PDC_Base\Core\PostType;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\TestCase;

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

		$config->shouldReceive('get')->with('posttypes')->once()->andReturn($configPostTypes);

		//test for filter being called
		\WP_Mock::expectFilter('owc/pdc_base/config/posttypes', $configPostTypes );

		$service->register();

		$this->assertEquals( $configPostTypes, $service->getConfigPostTypes());
	}
}
