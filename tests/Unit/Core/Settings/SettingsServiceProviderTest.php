<?php

namespace OWC_PDC_Base\Core\Settings;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\Unit\TestCase;

class SettingsServiceProviderTest extends TestCase
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
	public function check_registration_of_settings_metaboxes()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

		$plugin->config = $config;
		$plugin->loader = m::mock(Loader::class);

		$service = new SettingsServiceProvider($plugin);

		$plugin->loader->shouldReceive('addFilter')->withArgs([
			'mb_settings_pages',
			$service,
			'registerSettingsPage',
			10,
			1
		])->once();

		$plugin->loader->shouldReceive('addFilter')->withArgs([
			'rwmb_meta_boxes',
			$service,
			'registerSettings',
			10,
			1
		])->once();

		$plugin->loader->shouldReceive('addAction')->withArgs([
			'admin_init',
			$service,
			'getSettingsOption'
		])->once();

		$service->register();

		$configSettingsPage = [
			'base' => [
				'id'          => 'base_settings_page',
				'option_name' => 'base_settings_page'
			]
		];

		$config->shouldReceive('get')->with('settings_pages')->once()->andReturn($configSettingsPage);

		$this->assertEquals($configSettingsPage, $service->registerSettingsPage([]));

		$existingSettingsPage = [
			0 => [
				'id'          => 'existing_settings_page',
				'option_name' => 'existing_settings_page'
			]
		];

		$existingSettingsPageAfterMerge = [

			0      => [
				'id'          => 'existing_settings_page',
				'option_name' => 'existing_settings_page'
			],
			'base' => [
				'id'          => 'base_settings_page',
				'option_name' => 'base_settings_page'
			]
		];

		$config->shouldReceive('get')->with('settings_pages')->once()->andReturn($configSettingsPage);

		$this->assertEquals($existingSettingsPageAfterMerge, $service->registerSettingsPage($existingSettingsPage));

		$configMetaboxes = [
			'base' => [
				'id'             => 'metadata',
				'settings_pages' => 'base_settings_page',
				'fields'         => [
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

		$prefix = SettingsServiceProvider::PREFIX;

		$expectedMetaboxes = [
			0 => [
				'id'             => 'metadata',
				'settings_pages' => 'base_settings_page',
				'fields'         => [
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

		$config->shouldReceive('get')->with('settings')->once()->andReturn($configMetaboxes);

		//test for filter being called
		\WP_Mock::expectFilter('owc/pdc_base/before_register_settings', $expectedMetaboxes);

		$this->assertEquals($expectedMetaboxes, $service->registerSettings([]));

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
				'id'             => 'metadata',
				'settings_pages' => 'base_settings_page',
				'fields'         => [
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

		$config->shouldReceive('get')->with('settings')->once()->andReturn($configMetaboxes);

		$this->assertEquals($expectedMetaboxesAfterMerge, $service->registerSettings($existingMetaboxes));
	}
}
