<?php

namespace OWC_PDC_Base\Core\RestApi;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\TestCase;

class RestApiServiceProviderTest extends TestCase
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
	public function check_registration_of_rest_endpoints()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

		$plugin->config = $config;
		$plugin->loader = m::mock(Loader::class);

		$service = new RestApiServiceProvider($plugin);

		$plugin->loader->shouldReceive('addFilter')->withArgs([
			'rest_api_init',
			$service,
			'registerRestApiEndpointsFields',
			10
		])->once();

		$plugin->loader->shouldReceive('addFilter')->withArgs([
			'rest_prepare_pdc-item',
			$service,
			'filterRestPreparePdcItem',
			10,
			3
		])->once();

		$service->register();

		$this->assertTrue(true);

		$configRestApiFields = [
			'posttype1' => [
				'endpoint_field1' =>
					[
						'get_callback'    => ['object', 'callback1'],
						'update_callback' => null,
						'schema'          => null,
					],
				'endpoint_field2' =>
					[
						'get_callback'    => ['object', 'callback2'],
						'update_callback' => null,
						'schema'          => null,
					]
			],
			'posttype2' => [
				'endpoint_field1' =>
					[
						'get_callback'    => ['object', 'callback1'],
						'update_callback' => null,
						'schema'          => null,
					],
				'endpoint_field2' =>
					[
						'get_callback'    => ['object', 'callback2'],
						'update_callback' => null,
						'schema'          => null,
					]
			]
		];

		$config->shouldReceive('get')->with('rest_api_fields')->once()->andReturn($configRestApiFields);

		//test for filter being called
		\WP_Mock::expectFilter('owc/pdc_base/config/rest_api_fields_per_posttype', $configRestApiFields);

		\WP_Mock::userFunction('post_type_exists', [
				'args'   => [\WP_Mock\Functions::anyOf('posttype1', 'posttype2')],
				'times'  => '0+',
				'return' => true
			]
		);

		\WP_Mock::userFunction('register_rest_field', [
			'args'   => [
				\WP_Mock\Functions::anyOf('posttype1', 'posttype2'),
				\WP_Mock\Functions::anyOf('endpoint_field1', 'endpoint_field2'),
				'*'
			],
			'times'  => '0+'
		]);

		$service->registerRestApiEndpointsFields();

		$this->assertTrue(true);
	}
}
