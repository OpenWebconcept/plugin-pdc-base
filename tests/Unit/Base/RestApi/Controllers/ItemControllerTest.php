<?php

namespace OWC\PDC\Base\RestAPI\Controllers;

use Mockery as m;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;

class ItemControllerTest extends TestCase
{
    /** @var ItemController */
    private $itemController;

    public function setUp(): void
    {
        $plugin               = m::mock(Plugin::class);
        $this->itemController = new ItemController($plugin);
        \WP_Mock::setUp();
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function is_instance_of_ItemController(): void
    {
        $this->assertInstanceOf('OWC\PDC\Base\RestAPI\Controllers\ItemController', $this->itemController);
    }

    /** @test */
    public function it_needs_no_authorization_if_pdc_internal_products_plugin_is_not_active(): void
    {
        \WP_Mock::userFunction('is_plugin_active')
        ->withArgs([ 'pdc-internal-products/pdc-internal-products.php' ])
        ->once()
        ->andReturn(false);

        $actual = $this->invokeMethod($this->itemController, 'needsAuthorization', [[]]);

        $this->assertFalse($actual);
    }

    /** @test */
    public function it_fails_if_pdc_internal_products_plugin_is_not_active(): void
    {
        \WP_Mock::userFunction('is_plugin_active')
         ->withArgs([ 'pdc-internal-products/pdc-internal-products.php' ])
         ->once()
         ->andReturn(false);

        $actual = $this->invokeMethod($this->itemController, 'needsAuthorization', [[]]);

        $this->assertFalse($actual);
    }

    /** @test */
    public function it_needs_no_authorization_if_requested_item_has_no_type_taxonomy(): void
    {
        \WP_Mock::userFunction('is_plugin_active')
         ->withArgs([ 'pdc-internal-products/pdc-internal-products.php' ])
         ->once()
         ->andReturn(true);

        $actual = $this->invokeMethod($this->itemController, 'needsAuthorization', [[]]);

        $this->assertFalse($actual);
    }

    /** @test */
    public function it_needs_authorization_if_requested_item_has_a_type_taxonomy_of_internal(): void
    {
        $item = [
            'taxonomies' => [
                'pdc-type' => [
                    ['slug' => 'internal'],
                ]
            ],
        ];

        \WP_Mock::userFunction('is_plugin_active')
             ->withArgs([ 'pdc-internal-products/pdc-internal-products.php' ])
             ->once()
             ->andReturn(true);

        $actual = $this->invokeMethod($this->itemController, 'needsAuthorization', [$item]);

        $this->assertTrue($actual);
    }

    /** @test */
    public function it_needs_no_authorization_if_requested_item_has_a_type_taxonomy_of_external(): void
    {
        $item = [
            'taxonomies' => [
                'pdc-type' => [['slug' => 'external']],
            ],
        ];
        \WP_Mock::userFunction('is_plugin_active')
                ->withArgs([ 'pdc-internal-products/pdc-internal-products.php' ])
                ->once()
                ->andReturn(true);

        $actual = $this->invokeMethod($this->itemController, 'needsAuthorization', [$item]);

        $this->assertFalse($actual);
    }

    /** @test */
    public function it_needs_no_authorization_if_requested_item_has_a_type_taxonomy_of_both_external_and_internal(): void
    {
        $item = [
            'taxonomies' => [
                'pdc-type' => [
                    ['slug' => 'internal'],
                    ['slug' => 'external'],
                ],
            ],
        ];

        \WP_Mock::userFunction('is_plugin_active')
                 ->withArgs([ 'pdc-internal-products/pdc-internal-products.php' ])
                 ->once()
                 ->andReturn(true);

        $actual = $this->invokeMethod($this->itemController, 'needsAuthorization', [$item]);

        $this->assertFalse($actual);
    }
}
