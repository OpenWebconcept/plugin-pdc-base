<?php

namespace OWC\PDC\Base\UPL\Enrichment\Services;

use WP_Post;
use OWC\PDC\Base\Models\EnrichmentProduct;
use OWC\PDC\Base\UPL\Enrichment\Models\Doelgroep;

class EnrichmentProductResolver
{
    protected WP_Post $post;
    protected array $enrichment;

    public function __construct(WP_Post $post)
    {
        $this->post = $post;
    }

    public function resolve(): EnrichmentProduct
    {
        $data = [
            'upnLabel' => $this->getEnrichmentMeta('label'),
            'upnUri' => $this->getEnrichmentMeta('uri'),
            'uuid' => $this->getEnrichmentMeta('uuid'),
            'publicatieDatum' => date('Y-m-d'),
            'productAanwezig' => $this->isProductPresent(),
            'productValtOnder' => $this->getEnrichmentMeta('part_of'),
            'verantwoordelijkeOrganisatie'  => $this->getEnrichmentMeta('qualified_organization'),
            'bevoegdeOrganisatie' => $this->getEnrichmentMeta('responsible_organization', []),
            'catalogus' => $this->getEnrichmentMeta('catalogus', ''), // Ongeldige hyperlink - Object bestaat niet.
            'locaties' => $this->getEnrichmentMeta('locations', []),
            'doelgroep' => $this->getEnrichmentMeta('audience', Doelgroep::TYPE_CITIZEN),
            'vertalingen'  => $this->getTranslations(),
            'beschikbareTalen' => $this->getEnrichmentMeta('available_languages', [])
        ];

        return new EnrichmentProduct($data);
    }

    public function getMeta(string $name)
    {
        $name = '_owc_' . $name;
        return \get_post_meta($this->post->ID, $name, true);
    }

    public function isProductPresent(): ?bool
    {
        $result = $this->getEnrichmentMeta('product_present');

        if ($result === 'null') {
            return null;
        }

        return filter_var($result, FILTER_VALIDATE_BOOLEAN) ? true : false;
    }

    public function getEnrichmentMeta(string $name, $default = null)
    {
        $name = '_owc_enrichment_' . $name;
        $value = \get_post_meta($this->post->ID, $name, true);

        return ! empty($value) ? $value : $default;
    }

    protected function getTranslations(): array
    {
        $translation  = $this->getEnrichmentMeta('language', []);
        $otherTranslations = $this->getEnrichmentMeta('other_languages', []);

        if (! is_array($otherTranslations)) {
            $otherTranslations = [];
        }

        $combined = [];
        $combined[] = $translation; // insert one dimensional array in to multi dimensional

        foreach ($otherTranslations as $translation) {
            $combined[] = $translation;
        }

        return $this->translationKeysToOriginal($combined);
    }

    protected function translationKeysToOriginal(array $translations): array
    {
        return array_map(function ($translation) {
            return $this->mapTranslationKeysToOriginal($translation);
        }, $translations);
    }

    protected function mapTranslationKeysToOriginal(array $translation): array
    {
        $mapping = [
            'enrichment_language' => 'taal',
            'enrichment_title' => 'titel',
            //'enrichment_national_text' => 'nationale_tekst', // bestaat nog niet
            'enrichment_sdg_example_text' => 'tekst',
            'enrichment_links' => 'links',
            'enrichment_procedure_desc' => 'procedureBeschrijving',
            'enrichment_proof' => 'bewijs',
            'enrichment_requirements' => 'vereisten',
            'enrichment_object_and_appeal' => 'bezwaarEnBeroep',
            'enrichment_payment_methods' => 'kostenEnBetaalmethoden',
            'enrichment_deadline' => 'uitersteTermijn',
            'enrichment_action_when_no_reaction' =>'wtdBijGeenReactie',
            'enrichment_procedure_link' =>'procedureLink',
            'enrichment_product_present_explanation' => 'productAanwezigToelichting',
            'enrichment_product_belongs_to_explanation' => 'productValtOnderToelichting'
        ];

        $mapped = [];

        foreach ($translation as $key => $part) {
            if (empty($mapping[$key])) {
                continue;
            }

            $mapped[$mapping[$key]] = $part;
        }

        return $mapped;
    }
}
