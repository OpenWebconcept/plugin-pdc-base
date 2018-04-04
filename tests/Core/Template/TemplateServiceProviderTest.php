<?php

namespace OWC_PDC_Base\Core\Template;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\TestCase;

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
	public function check_registration_of_template()
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
}
