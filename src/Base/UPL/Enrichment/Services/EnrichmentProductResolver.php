<?php

namespace OWC\PDC\Base\UPL\Enrichment\Services;

use League\HTMLToMarkdown\HtmlConverter;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use OWC\PDC\Base\UPL\Enrichment\Models\Doelgroep;
use OWC\PDC\Base\UPL\Enrichment\Models\EnrichmentProduct;
use WP_Post;

class EnrichmentProductResolver
{
    use CheckPluginActive;

    protected WP_Post $post;
    protected array $enrichment;

    public function __construct(WP_Post $post)
    {
        $this->post = $post;
    }

    public function resolve(): EnrichmentProduct
    {
        // EnrichmentProduct in andere klasse en functies die ik moet omzetten daarmee overschrijven
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
        $translation = $this->getEnrichmentMeta('language', []);
        $translation = $this->convertLinks($translation);
        $translation = $this->convertProcedureLink($translation);

        if ($this->isPluginPDCFAQActive()) {
            $translation = $this->replaceSdgFaq($translation);
        }

        $otherTranslations = $this->getEnrichmentMeta('other_languages', []);

        if (! is_array($otherTranslations)) {
            $otherTranslations = [];
        }

        $combined = [];
        $combined[] = $translation; // Insert one-dimensional array in to multidimensional.

        foreach ($otherTranslations as $translation) {
            $combined[] = $translation;
        }

        $withOriginalKeys = $this->translationKeysToOriginal($combined);

        return $this->translationValuesToMarkdown($withOriginalKeys);
    }

    /**
     * Retrieved from the SDG in Markdown and parsed to HTML for usage in Wordpress.
     * Before pushing back to the SDG convert HTML back to Markdown.
     */
    protected function translationValuesToMarkdown(array $translations): array
    {
        $keysToConvert  = [
            'tekst',
            'procedureBeschrijving',
            'bewijs',
            'vereisten',
            'bezwaarEnBeroep',
            'kostenEnBetaalmethoden',
            'uitersteTermijn',
            'wtdBijGeenReactie',
        ];

        $converter = new HtmlConverter();

        return array_map(function ($translation) use ($keysToConvert, $converter) {
            foreach ($keysToConvert as $key) {
                if (empty($translation[$key])) {
                    continue;
                }
                $translation[$key] = $converter->convert($translation[$key]);
            }

            return $translation;
        }, $translations);
    }


    /**
     * Metabox key_value field type does not accept associative keys inside a multidimensional array.
     * The multidimensional array is converted to an indexed one.
     * Now convert back to the input facility required format.
     */
    protected function convertLinks(array $translation): array
    {
        $translation['enrichment_links'] = array_map(function ($link) {
            return ['label' => $link[0], 'url' => $link[1]];
        }, $translation['enrichment_links']);

        return $translation;
    }

    /**
     * Metabox key_value field type does not accept associative keys inside a multidimensional array.
     * The multidimensional array is converted to an indexed one.
     * Now convert back to the input facility required format.
     */
    protected function convertProcedureLink(array $translation): array
    {
        $translation['enrichment_procedure_link'] = array_map(function ($link) {
            return ['label' => $link[0], 'url' => $link[1]];
        }, $translation['enrichment_procedure_link']);

        // Metabox is saving this as an multidimensional array, an one-dimensional array is required.
        $translation['enrichment_procedure_link'] = $translation['enrichment_procedure_link'][0];

        return $translation;
    }

    /**
     * If the pdc-faq plugin is enabled it is possible to connect the pdc-faq questions with the SDG FAQ questions.
     * The pdc-faq questions will be send to the SDG if a connection is there.
     */
    protected function replaceSdgFaq(array $translation): array
    {
        $FAQs = $this->getMeta('pdc_faq_group');

        foreach ($FAQs as $FAQ) {
            if (empty($FAQ['pdc_faq_connect_sdq_faq']) || ! in_array('sdg', $FAQ['pdc_faq_usage'] ?? [])) {
                continue;
            }

            $translation[$FAQ['pdc_faq_connect_sdq_faq']] = $FAQ['pdc_faq_answer'];
        }

        return $translation;
    }

    protected function translationKeysToOriginal(array $translations): array
    {
        return array_map(function ($translation) {
            return $this->mapTranslationKeysToOriginal($translation);
        }, $translations);
    }

    /**
     * Translation array contains Wordpress meta keys.
     * This needs to be converted to the SDG keys required.
     */
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
