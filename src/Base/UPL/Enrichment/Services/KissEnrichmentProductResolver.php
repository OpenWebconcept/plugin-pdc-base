<?php

namespace OWC\PDC\Base\UPL\Enrichment\Services;

use League\HTMLToMarkdown\HtmlConverter;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use OWC\PDC\Base\UPL\Enrichment\Models\Doelgroep;
use OWC\PDC\Base\UPL\Enrichment\Models\EnrichmentProduct;
use WP_Post;

class KissEnrichmentProductResolver extends EnrichmentProductResolver
{
	public function __construct(WP_Post $post)
    {
		parent::__construct( $post );
    }

    public function resolve(): EnrichmentProduct
    {
        // EnrichmentProduct in andere klasse en functies die ik moet omzetten daarmee overschrijven
        $data = [
            'upnLabel' => $this->getEnrichmentMeta('label'),
            'upnUri' => $this->getEnrichmentMeta('uri'),
	        'id' => $this->getEnrichmentMeta('uuid'),
            'uuid' => $this->getEnrichmentMeta('uuid'),
	        'versie' => '1',
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

    /**
     * Translation array contains Wordpress meta keys.
     * This needs to be converted to the SDG keys required.
     */
    protected function mapTranslationKeysToOriginal(array $translation): array
    {
        $mapping = [
            'enrichment_language' => 'taal',
            'enrichment_title' => 'productTitelDecentraal',
            'enrichment_sdg_example_text' => 'specifiekeTekst',
            'enrichment_links' => 'verwijzingLinks',
            'enrichment_procedure_desc' => 'procedureBeschrijving',
            'enrichment_proof' => 'bewijs',
            'enrichment_requirements' => 'vereisten',
            'enrichment_object_and_appeal' => 'bezwaarEnBeroep',
            'enrichment_payment_methods' => 'kostenEnBetaalmethoden',
            'enrichment_deadline' => 'uitersteTermijn',
            'enrichment_action_when_no_reaction' =>'wtdBijGeenReactie',
            'enrichment_procedure_link' =>'decentraleProcedureLink',
            'enrichment_product_present_explanation' => 'productAanwezigToelichting',
            'enrichment_product_belongs_to_explanation' => 'productValtOnderToelichting'
        ];

        $mapped = [];

        foreach ($mapping as $metaKey => $originalKey) {
            if (empty($translation[$metaKey])) {
                $mapped[$originalKey] = '';
                continue;
            }

            $mapped[$originalKey] = $translation[$metaKey];
        }

        return $mapped;
    }
}
