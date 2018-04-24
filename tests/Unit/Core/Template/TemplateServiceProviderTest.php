<?php

namespace OWC_PDC_Base\Core\Template;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\Unit\TestCase;

class TemplateServiceProviderTest extends TestCase
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
	public function check_template_redirect_action()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

		$plugin->config = $config;
		$plugin->loader = m::mock(Loader::class);

		$service = new TemplateServiceProvider($plugin);

		$plugin->loader->shouldReceive('addAction')->withArgs([
			'template_redirect',
			$service,
			'redirectAllButAdmin',
			10
		])->once();

		$service->register();

		$this->assertTrue(true);
	}

	/** @test */
	public function check_redirect_all_but_admin_method()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(BasePlugin::class);

		$plugin->config = $config;
		$plugin->loader = m::mock(Loader::class);

		$service = new TemplateServiceProvider($plugin);

		\WP_Mock::userFunction('is_admin', [
				'args'   => null,
				'times'  => '1',
				'return' => false
			]
		);

		\WP_Mock::userFunction('wp_doing_ajax', [
				'args'   => null,
				'times'  => '1',
				'return' => false
			]
		);

		\WP_Mock::userFunction('is_feed', [
				'args'   => null,
				'times'  => '1',
				'return' => false
			]
		);

		\WP_Mock::userFunction('wp_redirect', [
				'args'   => 'https://www.openwebconcept.nl/',
				'times'  => '1',
				'return' => false
			]
		);

		$service->redirectAllButAdmin();

		$this->assertTrue(true);
	}

}
