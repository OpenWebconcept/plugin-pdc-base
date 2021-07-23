<?php

namespace OWC\PDC\Base\Metabox\Handler;

use OWC\PDC\Base\Tests\Unit\TestCase;
use OWC\PDC\Base\Metabox\Handlers\UPLNameHandler;

class UPLNameHandlerTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();

        $options = [
            [
                'UniformeProductnaam' => [
                    'value' => 'upl1'
                ]
            ],
            [
                'UniformeProductnaam' => [
                    'value' => ''
                ]
            ]
        ];

        $this->nameHandler = new UPLNameHandler($options);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function prepare_options_upl_metabox_correctly()
    {
        $actual = $this->nameHandler->getOptions();
        $expected = [
            [
                'value' => 'upl1',
                'label' => 'Upl1'
            ]
        ];

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function prepare_options_upl_metabox_wrongly()
    {
        $actual = $this->nameHandler->getOptions();
        $expected = [
            [
                'value' => 'upl1',
                'label' => 'Upl1'
            ],
            [
                'value' => '',
                'label' => ''
            ]
        ];

        $this->assertNotEquals($expected, $actual);
    }
}
