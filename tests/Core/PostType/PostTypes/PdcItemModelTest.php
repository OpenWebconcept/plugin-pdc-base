<?php

namespace OWC_PDC_Base\Core\PostType;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\PostType\PostTypes\PdcItemModel;
use OWC_PDC_Base\Core\Tests\TestCase;

class PdcItemModelTest extends TestCase
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
		$pdc_item = m::mock(PdcItemModel::class);

		$model = new PdcItemModel($config);

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
