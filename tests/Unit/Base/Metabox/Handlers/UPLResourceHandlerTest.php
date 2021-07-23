<?php

namespace OWC\PDC\Base\Metabox\Handler;

use OWC\PDC\Base\Tests\Unit\TestCase;
use OWC\PDC\Base\Metabox\Handlers\UPLResourceHandler;
use stdClass;

class UPLResourceHandlerTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();

        $this->post            = new stdClass();
        $this->resourceHandler = new UPLResourceHandler();
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function object_is_pdc_item()
    {
        $this->post->post_type = 'pdc-item';

        \WP_Mock::userFunction('get_post')
            ->withArgs([1])
            ->once()
            ->andReturn($this->post);

        $actual   = $this->resourceHandler->objectIsPDC(1);
        $expected = true;

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function object_is_not_a_pdc_item()
    {
        $this->post->post_type = 'no-pdc-item';

        \WP_Mock::userFunction('get_post')
            ->withArgs([1])
            ->once()
            ->andReturn($this->post);

        $actual   = $this->resourceHandler->objectIsPDC(1);
        $expected = false;

        $this->assertEquals($expected, $actual);
    }
}
