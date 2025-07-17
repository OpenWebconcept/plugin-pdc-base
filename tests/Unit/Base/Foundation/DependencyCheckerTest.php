<?php

namespace OWC\PDC\Base\Foundation;

use OWC\PDC\Base\Tests\Unit\TestCase;

class DependencyCheckerTest extends TestCase
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
    public function it_fails_when_plugin_is_inactive()
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Dependency #1',
                'file' => 'test-plugin/test-plugin.php'
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs([ 'test-plugin/test-plugin.php' ])
            ->once()
            ->andReturn(false);

        $this->assertTrue($checker->failed());
    }

    /** @test */
    public function it_succeeds_when_no_dependencies_are_set()
    {
        $checker = new DependencyChecker([]);

        \WP_Mock::userFunction('is_plugin_active')
            ->never();

        $this->assertFalse($checker->failed());
    }

    /**
     * @dataProvider wrongVersions
     *
     * @test
     */
    public function it_fails_when_plugin_is_active_but_versions_mismatch($version)
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Dependency #1',
                'file' => 'pluginstub.php', // tests/Unit/pluginstub.php
                'version' => $version // Version in pluginstub.php is 1.1.5
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs([ 'pluginstub.php' ])
            ->once()
            ->andReturn(true);

        $this->assertTrue($checker->failed());
    }

    /**
     * @dataProvider correctVersions
     *
     * @test
     */
    public function it_succeeds_when_plugin_is_active_and_versions_match($version)
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Dependency #1',
                'file' => 'pluginstub.php', // tests/Unit/pluginstub.php
                'version' => $version // Version in pluginstub.php is 1.1.5
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs([ 'pluginstub.php' ])
            ->once()
            ->andReturn(true);

        $this->assertFalse($checker->failed());
    }

    /** @test */
    public function it_succeeds_when_first_alternative_plugin_is_active()
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Meta Box',
                'file' => 'meta-box/meta-box.php',
                'alternatives' => [
                    'meta-box/meta-box.php',
                    'meta-box-aio/meta-box-aio.php'
                ]
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['meta-box/meta-box.php'])
            ->once()
            ->andReturn(true);

        $this->assertFalse($checker->failed());
    }

    /** @test */
    public function it_succeeds_when_second_alternative_plugin_is_active()
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Meta Box',
                'file' => 'meta-box/meta-box.php',
                'alternatives' => [
                    'meta-box/meta-box.php',
                    'meta-box-aio/meta-box-aio.php'
                ]
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['meta-box/meta-box.php'])
            ->once()
            ->andReturn(false);
            
        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['meta-box-aio/meta-box-aio.php'])
            ->once()
            ->andReturn(true);

        $this->assertFalse($checker->failed());
    }

    /** @test */
    public function it_fails_when_no_alternative_plugins_are_active()
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Meta Box',
                'file' => 'meta-box/meta-box.php',
                'alternatives' => [
                    'meta-box/meta-box.php',
                    'meta-box-aio/meta-box-aio.php'
                ]
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['meta-box/meta-box.php'])
            ->once()
            ->andReturn(false);
            
        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['meta-box-aio/meta-box-aio.php'])
            ->once()
            ->andReturn(false);

        $this->assertTrue($checker->failed());
    }

    /** @test */
    public function it_succeeds_when_both_alternative_plugins_are_active()
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Meta Box',
                'file' => 'meta-box/meta-box.php',
                'alternatives' => [
                    'meta-box/meta-box.php',
                    'meta-box-aio/meta-box-aio.php'
                ]
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['meta-box/meta-box.php'])
            ->once()
            ->andReturn(true);

        // Should not check the second alternative since first one is active
        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['meta-box-aio/meta-box-aio.php'])
            ->never();

        $this->assertFalse($checker->failed());
    }

    /** @test */
    public function it_falls_back_to_original_behavior_when_no_alternatives_defined()
    {
        $dependencies = [
            [
                'type' => 'plugin',
                'label' => 'Regular Plugin',
                'file' => 'regular-plugin/regular-plugin.php'
            ]
        ];

        $checker = new DependencyChecker($dependencies);

        \WP_Mock::userFunction('is_plugin_active')
            ->withArgs(['regular-plugin/regular-plugin.php'])
            ->once()
            ->andReturn(true);

        $this->assertFalse($checker->failed());
    }

    /**
     * Provides old version numbers.
     * Version in pluginstub.php is 1.1.5
     *
     * @return array
     */
    public function wrongVersions()
    {
        return [
            [ '1.1.8' ],
            [ '2.0' ],
            [ '3' ]
        ];
    }

    public function correctVersions()
    {
        return [
            [ '1.1.2' ],
            [ '1.0' ],
            [ '1' ]
        ];
    }
}