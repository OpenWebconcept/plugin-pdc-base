<?php

namespace OWC_PDC_Base\Core\Admin;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\Unit\TestCase;

class InterfaceServiceProviderTest extends TestCase
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
	public function check_registration_of_interface_methods()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

		$plugin->config = $config;
		$plugin->loader = m::mock(Loader::class);

		$service = new InterfaceServiceProvider($plugin);

		$plugin->loader->shouldReceive('addFilter')->withArgs([
			'admin_bar_menu',
			$service,
			'filterAdminbarMenu',
			999
		])->once();

		$plugin->loader->shouldReceive('addFilter')->withArgs([
			'get_sample_permalink_html',
			$service,
			'filterGetSamplePermalinkHtml',
			10,
			5
		])->once();

		$plugin->loader->shouldReceive('addAction')->withArgs([
			'page_row_actions',
			$service,
			'actionModifyPageRowActions',
			999,
			2
		])->once();

		$service->register();

		$this->assertTrue(true);
	}

	/** @test */
	public function check_filter_get_sample_permalink_html_methods()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

		$plugin->config   = $config;
		$plugin->loader   = m::mock(Loader::class);
		$plugin->settings = [
			'_owc_setting_portal_url'           => 'http://owc-pdc.test',
			'_owc_setting_portal_pdc_item_slug' => 'onderwerp'
		];

		$service = new InterfaceServiceProvider($plugin);

		\WP_Mock::userFunction('trailingslashit', [
				'times'      => '2',
				'return' => function() { return func_get_arg(0).'/'; }
			]
		);

		$return = '';

		$post            = new \stdClass;
		$post->post_type = 'pdc-item';
		$post->post_name = 'test-pdc-item';

		$button = '<a href="http://owc-pdc.test/onderwerp/test-pdc-item" target="_blank"><button type="button" class="button button-small" aria-label="Bekijk in Portal">Bekijk in Portal</button></a>';

		$postId = $newTitle = $newSlug = null;

		$this->assertEquals( $return . $button, $service->filterGetSamplePermalinkHtml($return, $postId, $newTitle, $newSlug, $post));
	}
}
