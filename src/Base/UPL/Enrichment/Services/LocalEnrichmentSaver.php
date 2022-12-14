<?php

namespace OWC\PDC\Base\UPL\Enrichment\Services;

use WP_Post;
use DateTime;
use OWC\PDC\Base\UPL\Enrichment\Models\EnrichmentProduct;

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
        $this->saveDefaultsToFAQs();

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

    /**
     * Add the default text from the SDG questions to PDC-FAQs
     * Default texts are used for demostration purposes.
     */
    protected function saveDefaultsToFAQs(): void
    {
        $defaultFAQs = $this->faqDefaults();
        $groupsFAQ = \get_post_meta($this->post->ID, '_owc_pdc_faq_group', true);

        if (empty($groupsFAQ)) {
            return;
        }

        $mapped = array_map(function ($group) use ($defaultFAQs) {
            $group['pdc_faq_enrichment_procedure_desc_default'] = $defaultFAQs['enrichment_procedure_desc_default'] ?: __('No default available.', 'pdc-base');
            $group['pdc_faq_enrichment_proof_default'] = $defaultFAQs['enrichment_proof_default'] ?: __('No default available.', 'pdc-base');
            $group['pdc_faq_enrichment_requirements_default'] = $defaultFAQs['enrichment_requirements_default'] ?: __('No default available.', 'pdc-base');
            $group['pdc_faq_enrichment_object_and_appeal_default'] = $defaultFAQs['enrichment_object_and_appeal_default'] ?: __('No default available.', 'pdc-base');
            $group['pdc_faq_enrichment_payment_methods_default'] = $defaultFAQs['enrichment_payment_methods_default'] ?: __('No default available.', 'pdc-base');
            $group['pdc_faq_enrichment_deadline_default'] = $defaultFAQs['enrichment_deadline_default'] ?: __('No default available.', 'pdc-base');
            $group['pdc_faq_enrichment_action_when_no_reaction_default'] = $defaultFAQs['enrichment_action_when_no_reaction_default'] ?: __('No default available.', 'pdc-base');

            return $group;
        }, $groupsFAQ);
        
        \update_post_meta($this->post->ID, '_owc_pdc_faq_group', $mapped);
    }

    protected function faqDefaults(): array
    {
        $keys = [
            'enrichment_procedure_desc_default',
            'enrichment_proof_default',
            'enrichment_requirements_default',
            'enrichment_object_and_appeal_default',
            'enrichment_payment_methods_default',
            'enrichment_deadline_default',
            'enrichment_action_when_no_reaction_default',
        ];

        return array_filter($this->getTranslationByLanguage(), function ($FAQ, $key) use ($keys) {
            return in_array($key, $keys) ? true : false;
        }, ARRAY_FILTER_USE_BOTH);
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
                'enrichment_procedure_desc_default' => $translation->procedureDesc(true),
                'enrichment_proof' => $translation->proof(),
                'enrichment_proof_default' => $translation->proof(true),
                'enrichment_requirements' => $translation->requirements(),
                'enrichment_requirements_default' => $translation->requirements(true),
                'enrichment_object_and_appeal' => $translation->objectionAndAppeal(),
                'enrichment_object_and_appeal_default' => $translation->objectionAndAppeal(true),
                'enrichment_payment_methods' => $translation->costAndPaymentMethods(),
                'enrichment_payment_methods_default' => $translation->costAndPaymentMethods(true),
                'enrichment_deadline' => $translation->deadline(),
                'enrichment_deadline_default' => $translation->deadline(true),
                'enrichment_action_when_no_reaction' => $translation->actionWhenNoReaction(),
                'enrichment_action_when_no_reaction_default' => $translation->actionWhenNoReaction(true),
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
