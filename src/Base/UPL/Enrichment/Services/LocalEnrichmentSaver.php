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
        $this->saveMeta('_owc_enrichment-language', $this->getTranslationByLanguage());
    }

    protected function saveEnrichmentData(): void
    {
        $this->saveEnrichmentMeta('url', $this->product->getUrl());
        $this->saveEnrichmentMeta('uuid', $this->product->getUuid());

        $this->saveEnrichmentMeta('label', $this->product->getLabel());
        $this->saveEnrichmentMeta('uri', $this->product->getURI());

        $this->saveEnrichmentMeta('version', $this->product->getVersion());
        $this->saveEnrichmentMeta('version_date', date('Y-m-d H:i:s'));

        $pubDate = $this->product->getPublicatieDatum();
        $this->saveEnrichmentMeta('publication_date', $pubDate ? $pubDate->format(DateTime::ATOM) : null);
        $this->saveEnrichmentMeta('product_present', $this->product->getProductAanwezig());
        $this->saveEnrichmentMeta('part_of', $this->product->getProductValtOnder());

        $this->saveEnrichmentMeta('responsible_organization', $this->product->getVerantwoordelijkeOrganisatie());
        $this->saveEnrichmentMeta('qualified_organization', $this->product->getBevoegdeOrganisate);

        $this->saveEnrichmentMeta('catalogus', $this->product->getCatalogus());
        $this->saveEnrichmentMeta('audience', $this->product->getLocaties());
        $this->saveEnrichmentMeta('locations', $this->product->getDoelgroep());
    }

    protected function getTranslationByLanguage(): array
    {
        $translations = $this->product->getTranslations();
        $language = $this->getMeta('_owc_pdc-item-language') ?: 'nl';

        $filtered = array_filter($translations, function ($translation) use ($language) {
            return $translation->getLanguage() === $language;
        });

        $mapped = array_map(function ($translation) {
            return [
                'enrichment_language' => $translation->getLanguage(),
                'enrichment_national_text' => $translation->getNationalText(),
                'enrichment_sdg_example_text' => $translation->getExampleTextSDG()
            ];
        }, $filtered);

        return array_values($mapped)[0] ?? [];
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
