<?php

namespace OWC\PDC\Base\UPL\Enrichment\Services;

use WP_Post;
use DateTime;
use OWC\PDC\Base\Models\EnrichmentProduct;

class LocalEnrichmentSaver
{
    protected WP_Post $post;
    protected EnrichmentProduct $product;

    public function __construct(WP_Post $post, EnrichmentProduct $product)
    {
        $this->post = $post;
        $this->product = $product;
    }

    public function save(): bool
    {
        $currentVersion = $this->getMeta('_owc_enrichment_version');
        $newVersion = (int) $this->product->getVersion();

        if ($newVersion <= $currentVersion) {
            return false;
        }

        $this->saveEnrichmentLanguage();
        $this->saveEnrichmentData();

        return true;
    }

    protected function saveEnrichmentLanguage(): void
    {
        $this->saveMeta('_owc_enrichment_language', $this->getTranslationByLanguage());
        $this->saveMeta('_owc_enrichment_other_languages', $this->getOtherTranslations());
    }

    protected function saveEnrichmentData(): void
    {
        $this->saveEnrichmentMeta('url', $this->product->getUrl());
        $this->saveEnrichmentMeta('uuid', $this->product->getUuid());

        $this->saveEnrichmentMeta('label', $this->product->getLabel());
        $this->saveEnrichmentMeta('uri', $this->product->getURI());

        $this->saveEnrichmentMeta('version', $this->product->getVersion());
        $this->saveEnrichmentMeta('version_date', date('Y-m-d H:i:s'));

        $pubDate = $this->product->getPublicationDate();
        $this->saveEnrichmentMeta('publication_date', $pubDate ? $pubDate->format(DateTime::ATOM) : null);
        $this->saveEnrichmentMeta('product_present', $this->product->getProductPresent());
        $this->saveEnrichmentMeta('part_of', $this->product->getProductBelongsTo());

        $this->saveEnrichmentMeta('responsible_organization', $this->product->getResponsibleOrganization());
        $this->saveEnrichmentMeta('qualified_organization', $this->product->getQualifiedOrganization());

        $this->saveEnrichmentMeta('catalogus', $this->product->getCatalogus());
        $this->saveEnrichmentMeta('audience', $this->product->getAudience());
        $this->saveEnrichmentMeta('locations', $this->product->getLocations());

        $this->saveEnrichmentMeta('available_languages', $this->product->getAvailableLanguages());
    }

    protected function getTranslationByLanguage(): array
    {
        $translations = $this->product->getTranslations();
        $language = $this->getMeta('_owc_pdc-item-language') ?: 'nl';

        $filtered = array_filter($translations, function ($translation) use ($language) {
            return $translation->language() === $language;
        });

        $mapped = $this->prepTranslationArray($filtered);

        return array_values($mapped)[0] ?? [];
    }

    protected function getOtherTranslations(): array
    {
        $translations = $this->product->getTranslations();
        $language = $this->getMeta('_owc_pdc-item-language') ?: 'nl';

        $filtered = array_filter($translations, function ($translation) use ($language) {
            return $translation->language() !== $language;
        });

        return array_values($this->prepTranslationArray($filtered));
    }

    protected function prepTranslationArray(array $translations): array
    {
        return array_map(function ($translation) {
            return [
                'enrichment_language' => $translation->language(),
                'enrichment_title' => $translation->title(),
                'enrichment_national_text' => $translation->nationalText(),
                'enrichment_sdg_example_text' => $translation->exampleTextSDG(),
                'enrichment_links' => $translation->links(),
                'enrichment_procedure_desc' => $translation->procedureDesc(),
                'enrichment_proof' => $translation->proof(),
                'enrichment_requirements' => $translation->requirements(),
                'enrichment_object_and_appeal' => $translation->objectionAndAppeal(),
                'enrichment_payment_methods' => $translation->costAndPaymentMethods(),
                'enrichment_deadline' => $translation->deadline(),
                'enrichment_action_when_no_reaction' => $translation->actionWhenNoReaction(),
                'enrichment_procedure_link' => $translation->procedureLink(),
                'enrichment_product_present_explanation' => $translation->productPresentExplanation(),
                'enrichment_product_belongs_to_explanation' => $translation->productBelongsToExplanation()
            ];
        }, $translations);
    }

    protected function getMeta(string $name)
    {
        return \get_post_meta($this->post->ID, $name, true);
    }

    protected function saveMeta(string $name, $value): bool
    {
        return (bool) \update_post_meta($this->post->ID, $name, $value);
    }

    public function saveEnrichmentMeta(string $name, $value): bool
    {
        return $this->saveMeta('_owc_enrichment_' . $name, $value);
    }
}
