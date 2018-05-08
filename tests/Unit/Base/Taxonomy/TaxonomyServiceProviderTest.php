<?php

namespace OWC\PDC\Base\Taxonomy;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Tests\Unit\TestCase;

class TaxonomyServiceProviderTest extends TestCase
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
	public function check_registration_of_taxonomies()
	{
		$config = m::mock(Config::class);
		$plugin = m::mock(Plugin::class);

		$plugin->config = $config;
		$plugin->loader = m::mock(Loader::class);

		$service = new TaxonomyServiceProvider($plugin);

		$plugin->loader->shouldReceive('addAction')->withArgs([
			'init',
			$service,
			'registerTaxonomies'
		])->once();

		/**
		 * Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
		 */
		$configTaxonomies = [
			'posttype' => [
				'object_types' => ['post'],
				'args'         => [
				],
				'names'        => [
				]
			]
		];

		$service->register();

		$this->assertTrue(true);
	}
}
