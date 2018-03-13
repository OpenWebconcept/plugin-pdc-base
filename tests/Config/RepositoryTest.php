<?php

namespace OWC_PDC_Base\Core\Tests\Config;

use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Tests\TestCase;

class RepositoryTest extends TestCase
{

    /**
     * @var \OWC_PDC_Base\Core\Config
     */
    protected $repository;

    /**
     * @var array
     */
    protected $config;

    public function setUp()
    {
        $this->repository = new Config(__DIR__.'/config');
        $this->repository->boot();
    }

    /** @test */
    public function gets_value_correctly()
    {
        $this->assertEquals([
            'test'      => [
                'single_file' => true
            ],
            'directory' => [
                'testfile' => [
                    'in_directory' => 'directory',
                ],
                'multi'    => [
                    'deep' => [
                        'multi_level' => 'works'
                    ]
                ]
            ]
        ], $this->repository->all());

        $this->assertEquals(true, $this->repository->get('test.single_file'));
        $this->assertEquals('directory', $this->repository->get('directory.testfile.in_directory'));
        $this->assertEquals('works', $this->repository->get('directory.multi.deep.multi_level'));
    }

}