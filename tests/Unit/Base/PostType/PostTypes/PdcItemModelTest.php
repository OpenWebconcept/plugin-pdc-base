<?php

namespace OWC\PDC\Base\PostType;

use Mockery as m;
use OWC\PDC\Base\Foundation\Config;
use OWC\PDC\Base\PostType\PostTypes\PdcItemModel;
use OWC\PDC\Base\Tests\Unit\TestCase;

class PdcItemModelTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function check_model_construct()
    {
        $config   = m::mock(Config::class);
        $pdc_item = m::mock(PdcItemModel::class);

        $model = new PdcItemModel($config);

        $this->assertTrue(true);
    }

    // /** @test */
    public function check_get_terms_as_array_methods()
    {
        $config   = m::mock(Config::class);
        $pdc_item = m::mock(PdcItemModel::class);

        $model = new PdcItemModel($config);

        $term1          = new \stdClass();
        $term1->term_id = 1;
        $term1->name    = 'term_name1';
        $term1->slug    = 'term_slug1';

        $term2          = new \stdClass();
        $term2->term_id = 2;
        $term2->name    = 'term_name2';
        $term2->slug    = 'term_slug2';

        $terms[] = $term1;
        $terms[] = $term2;

        $object     = [ 'id' => 1 ];
        $taxonomyId = 1;

        $output = [
            [
                'ID'   => 1,
                'name' => 'term_name1',
                'slug' => 'term_slug1'
            ],
            [
                'ID'   => 2,
                'name' => 'term_name2',
                'slug' => 'term_slug2'
            ]
        ];

        //$this->assertEquals( $output, $this->invokeMethod($model, 'getTermsAsArray', array($object, 1)));
    }
}
