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

        $this->saveMeta('_owc_enrichment-group', $this->getTranslationByLanguage());
        $this->saveEnrichmentMeta('version', $this->product->getVersion());
        $this->saveEnrichmentMeta('version_date', date('Y-m-d H:i:s'));

        $this->saveEnrichmentMeta('url', $this->product->getUrl());
        $this->saveEnrichmentMeta('uuid', $this->product->getUuid());

        $this->saveEnrichmentMeta('label', $this->product->getLabel());
        $this->saveEnrichmentMeta('uri', $this->product->getURI());

        return true;
    }

    protected function getTranslationByLanguage(): array
    {
        $translations = $this->product->getTranslations();
        $language = $this->getMeta('_owc_pdc-item-language') ?: 'nl';

        $filtered = array_filter($translations, function ($translation) use ($language) {
            return $translation->getLanguage() === $language;
        });

        $mapped = array_map(function ($translation) {
            $pubDate = $this->product->getPublicatieDatum();

            return [
                'enrichment_language' => $translation->getLanguage(),
                'enrichment_national_text' => $translation->getNationalText(),
                'enrichment_sdg_example_text' => $translation->getExampleTextSDG(),
                'enrichment_catalogus' => $this->product->getCatalogus(),
                'enrichment_product_present' => $this->product->getProductAanwezig(),
                'enrichment_audience' => $this->product->getDoelgroep(),
                'enrichment_part_of' => $this->product->getProductValtOnder(),
                'enrichment_responsible_organization' => $this->product->getVerantwoordelijkeOrganisatie(),
                'enrichment_qualified_organization' => $this->product->getBevoegdeOrganisate,
                'enrichment_locations' => $this->product->getLocaties(),
                'enrichment_publication_date' => $pubDate ? $pubDate->format(DateTime::ATOM) : null,
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
