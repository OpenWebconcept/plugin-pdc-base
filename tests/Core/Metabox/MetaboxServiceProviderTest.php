<?php

namespace OWC_PDC_Base\Core\Metabox;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\TestCase;

class MetaboxServiceProviderTest extends TestCase
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
	public function check_registration_of_metaboxes()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

		$plugin->config = $config;
		$plugin->loader = m::mock(Loader::class);

		$service = new MetaboxServiceProvider($plugin);

		$plugin->loader->shouldReceive('addFilter')->withArgs([
			'rwmb_meta_boxes',
			$service,
			'registerMetaboxes',
			10,
			1
		])->once();

		$service->register();

		$configMetaboxes = [
			'base' => [
				'id'     => 'metadata',
				'fields' => [
					'general' => [
						'testfield_noid' => [
							'type' => 'heading'
						],
						'testfield1'     => [
							'id' => 'metabox_id1'
						],
						'testfield2'     => [
							'id' => 'metabox_id2'
						]
					]
				]
			]
		];

		$prefix = MetaboxServiceProvider::PREFIX;

		$expectedMetaboxes = [
			0 => [
				'id'     => 'metadata',
				'fields' => [
					[
						'type' => 'heading'
					],
					[
						'id' => $prefix . 'metabox_id1'
					],
					[
						'id' => $prefix . 'metabox_id2'
					]
				]
			]
		];

		$config->shouldReceive('get')->with('metaboxes')->once()->andReturn($configMetaboxes);

		//test for filter being called
		\WP_Mock::expectFilter('owc/pdc_base/before_register_metaboxes', $expectedMetaboxes );

		$this->assertEquals($expectedMetaboxes, $service->registerMetaboxes([]));

		$existingMetaboxes = [
			0 => [
				'id'     => 'existing_metadata',
				'fields' => [
					[
						'type' => 'existing_heading'
					],
					[
						'id' => $prefix . 'existing_metabox_id1'
					],
					[
						'id' => $prefix . 'existing_metabox_id2'
					]
				]
			]
		];

		$expectedMetaboxesAfterMerge = [

			0 => [
				'id'     => 'existing_metadata',
				'fields' => [
					[
						'type' => 'existing_heading'
					],
					[
						'id' => $prefix . 'existing_metabox_id1'
					],
					[
						'id' => $prefix . 'existing_metabox_id2'
					]
				]
			],
			1 => [
				'id'     => 'metadata',
				'fields' => [
					[
						'type' => 'heading'
					],
					[
						'id' => $prefix . 'metabox_id1'
					],
					[
						'id' => $prefix . 'metabox_id2'
					]
				]
			]
		];

		$config->shouldReceive('get')->with('metaboxes')->once()->andReturn($configMetaboxes);

		$this->assertEquals($expectedMetaboxesAfterMerge, $service->registerMetaboxes($existingMetaboxes));
	}
}
