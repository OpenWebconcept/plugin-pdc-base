<?php

namespace OWC\PDC\Base\UPL;

use Mockery as m;
use OWC\PDC\Base\Support\Traits\RequestUPL;
use OWC\PDC\Base\UPL\IncorrectItems;
use OWC\PDC\Base\Tests\Unit\TestCase;

class UPLTest extends TestCase
{
    use RequestUPL;

    public function setUp(): void
    {
        \WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_pdc_item_slug'             => '',
                '_owc_setting_include_theme_in_portal_url'      => 0,
                '_owc_setting_include_subtheme_in_portal_url'   => 0,
                '_owc_setting_pdc-group'                        => 0,
                '_owc_setting_identifications'                  => 1,
                '_owc_setting_use_escape_element'               => 1,
                '_owc_upl_terms_url'                            => 'https://standaarden.overheid.nl/owms/oquery/UPL-gemeente.json'
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_pdc_item_slug'             => '',
                '_owc_setting_include_theme_in_portal_url'      => 0,
                '_owc_setting_include_subtheme_in_portal_url'   => 0,
                '_owc_setting_pdc-group'                        => 0,
                '_owc_setting_identifications'                  => 1,
                '_owc_setting_use_escape_element'               => 1,
                '_owc_upl_terms_url'                            => 'https://standaarden.overheid.nl/owms/oquery/UPL-gemeente.json'
            ]
        ]);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    protected function createItems(): array
    {
        return [
            ['id' => 1, 'uplName' => 'aanleunwoning', 'uplUrl' => 'http://standaarden.overheid.nl/owms/terms/aanleunwoning'],
            ['id' => 2, 'uplName' => 'fout', 'uplUrl' => 'http://standaarden.overheid.nl/owms/terms/fout'],
        ];
    }

    /** @test */
    public function compare_incorrect_items()
    {
        \WP_Mock::userFunction('get_transient')
            ->withArgs(['uplOptions'])
            ->once()
            ->andReturn(false);

        \WP_Mock::userFunction('wp_remote_get')
            ->withArgs(['https://standaarden.overheid.nl/owms/oquery/UPL-gemeente.json'])
            ->once()
            ->andReturn(['body' => '{
                "head" : {
                  "vars" : [
                    "UniformeProductnaam",
                    "URI",
                    "Burger",
                    "Bedrijf",
                    "Dienstenwet",
                    "SDG",
                    "Grondslaglabel",
                    "Grondslaglink"
                  ]
                },
                "results" : {
                  "bindings" : [
                    {
                      "UniformeProductnaam" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "UPL-naam nog niet beschikbaar"
                      },
                      "URI" : {
                        "type" : "uri",
                        "value" : "http://standaarden.overheid.nl/owms/terms/UPL-naam_nog_niet_beschikbaar"
                      }
                    },
                    {
                      "Burger" : {
                        "type" : "literal",
                        "value" : "X"
                      },
                      "UniformeProductnaam" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "aanleunwoning"
                      },
                      "URI" : {
                        "type" : "uri",
                        "value" : "http://standaarden.overheid.nl/owms/terms/aanleunwoning"
                      }
                    },
                    {
                      "Burger" : {
                        "type" : "literal",
                        "value" : "X"
                      },
                      "Grondslaglink" : {
                        "type" : "uri",
                        "value" : "https://wetten.overheid.nl/jci1.3:c:BWBR0005645&titeldeel=III&hoofdstuk=VIII&Paragraaf=4&artikel=122"
                      },
                      "UniformeProductnaam" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "aanschrijving"
                      },
                      "Grondslaglabel" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "Artikel 122 Provinciewet"
                      },
                      "URI" : {
                        "type" : "uri",
                        "value" : "http://standaarden.overheid.nl/owms/terms/aanschrijving"
                      },
                      "Bedrijf" : {
                        "type" : "literal",
                        "value" : "X"
                      }
                    }]}}']);

        \WP_Mock::userFunction('is_wp_error')
            ->once()
            ->andReturn(false);

        $result = (new IncorrectItems($this->createItems(), $this->getOptionsUPL()))->compareIncorrectItems();
        $expected = [['id' => 2, 'uplName' => 'fout', 'uplUrl' => 'http://standaarden.overheid.nl/owms/terms/fout']];

        $this->assertEquals(array_values($expected), array_values($result));
    }
}
