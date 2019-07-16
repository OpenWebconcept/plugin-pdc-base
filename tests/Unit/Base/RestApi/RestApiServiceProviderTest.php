<?php

namespace OWC\PDC\Base\RestAPI;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class RestAPIServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        \WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_rest_endpoints()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service = new RestAPIServiceProvider($plugin);

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'rest_api_init',
            $service,
            'registerRoutes'
        ])->once();

        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'owc/config-expander/rest-api/whitelist',
            $service,
            'whitelist',
            10,
            1
        ])->once();

        $fields = [
            'items' => [
                'fields' => [
                'taxonomies' => OWC\PDC\Base\RestAPI\ItemFields\TaxonomyField::class,
                'connected' => OWC\PDC\Base\RestAPI\ItemFields\ConnectedField::class,
                'image' => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'appointment' => OWC\PDC\Base\RestAPI\ItemFields\AppointmentField::class,
                'forms' => OWC\PDC\Base\RestAPI\ItemFields\FormsField::class,
                'downloads' => OWC\PDC\Base\RestAPI\ItemFields\DownloadsField::class,
                'links' => OWC\PDC\Base\RestAPI\ItemFields\LinksField::class,
                'title_alternative' => OWC\PDC\Base\RestAPI\ItemFields\TitleAlternativeField::class,
                'faq' => OWC\PDC\Base\RestAPI\ItemFields\FAQField::class
            ]
            ]
        ];

        $config->shouldReceive('get')->with('api.models')->once()->andReturn($fields);
        $service->register();

        $this->assertTrue(true);
    }
}
