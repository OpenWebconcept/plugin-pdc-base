<?php

namespace OWC_PDC_Base\Core\PostType;

use Mockery as m;
use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Plugin\BasePlugin;
use OWC_PDC_Base\Core\Plugin\Loader;
use OWC_PDC_Base\Core\Tests\TestCase;

require_once( 'extended-cpts/extended-cpts.php' );

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

		$service->register();

		/**
		 * Examples of registering post types: http://johnbillion.com/extended-cpts/
		 */
		$configPostTypes = [
			'posttype'        => [
				'args'  => [

					# Add the post type to the site's main RSS feed:
					'show_in_feed'          => false,

					# Show all posts on the post type archive:
					'archive'               => [
						'nopaging' => true
					],
					'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
					'show_in_rest'          => true,
					'rest_base'             => 'pdc-item',
					'rest_controller_class' => '\\OWC_PDC_Base\\Core\\RestApi\\RestPdcItemPostsController',
				],
				'names' => [

					# Override the base names used for labels:
					'singular' => _x('PDC item', 'Posttype definitie', 'pdc-base'),
					'plural'   => _x('PDC items', 'Posttype definitie', 'pdc-base'),
					'slug'     => 'pdc-item'
				]
			]
		];

		$config->shouldReceive('get')->with('posttypes')->once()->andReturn($configPostTypes);

		//test for filter being called
		\WP_Mock::expectFilter('owc/pdc_base/config/posttypes', $configPostTypes );

		var_dump( $configPostTypes, $service->registerPostTypes());
		exit;

		$this->assertInstanceOf(Extended_CPT::class, $service->registerPostTypes());
	}
}
