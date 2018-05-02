<?php

namespace OWC_PDC_Base\Core\Tests\Config;

use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Tests\Unit\TestCase;

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
		\WP_Mock::setUp();

		$this->repository = new Config(__DIR__ . '/config');
	}

	public function tearDown()
	{
		\WP_Mock::tearDown();
	}

	/** @test */
	public function gets_value_correctly()
	{
		$this->repository->boot();

		$config = [
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
		];

		$this->assertEquals($config, $this->repository->all());
		$this->assertEquals($config, $this->repository->get(false));
		$this->assertEquals(true, $this->repository->get('test.single_file'));
		$this->assertEquals('directory', $this->repository->get('directory.testfile.in_directory'));
		$this->assertEquals('works', $this->repository->get('directory.multi.deep.multi_level'));
	}

	/** @test */
	public function check_correct_filter_usage()
	{
		$this->repository->boot();

		$this->repository->setPluginName('pdc-test');
		$this->repository->all();

		$expectedFilterArgs1 = [
			'multi_level' => 'works'
		];

		$filteredFilterArgs = [
			'multi_level' => 'works-test'
		];

		$expectedFilterArgs2 = [
			'in_directory' => 'directory'
		];

		$expectedFilterArgs3 = [
			'single_file' => true
		];

		//test for filter being called

		\WP_Mock::expectFilter('owc/pdc-test/config/directory/testfile', $expectedFilterArgs2);
		\WP_Mock::expectFilter('owc/pdc-test/config/test', $expectedFilterArgs3);

		\WP_Mock::onFilter('owc/pdc-test/config/directory/multi/deep')
			->with($expectedFilterArgs1)
			->reply($filteredFilterArgs);

		$this->repository->filter();

		$expectedConfig = [
			'test'      => [
				'single_file' => true
			],
			'directory' => [
				'testfile' => [
					'in_directory' => 'directory',
				],
				'multi'    => [
					'deep' => [
						'multi_level' => 'works-test'
					]
				]
			]
		];

		$this->assertEquals($expectedConfig, $this->repository->all());
	}

	/** @test */
	public function check_setting_of_path()
	{

		$path = '/test/path/config/';
		$this->repository->setPath($path);

		$this->assertEquals($this->repository->getPath(), $path);
	}

	/** @test */
	public function check_filter_exceptions()
	{
		$this->repository->setPluginName('pdc-test');
		$this->repository->setFilterExceptions(['test']);
		$this->repository->boot();

		$this->repository->all();

		$expectedFilterArgs2 = [
			'in_directory' => 'directory'
		];

		$expectedFilterArgs3 = [
			'single_file' => true
		];

		//test for filter being called
		\WP_Mock::expectFilter('owc/pdc-test/config/directory/testfile', $expectedFilterArgs2);

		$this->repository->filter();

		$this->assertTrue(true);
	}
}