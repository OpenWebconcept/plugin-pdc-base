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
        $this->enrichment = (array) $this->getMeta('_owc_enrichment');
    }

    public function resolve(): EnrichmentProduct
    {
        $data = [
            'upnLabel' => $this->getMeta('_owc_enrichment_label'),
            'upnUri' => $this->getMeta('_owc_enrichment_uri'),
            'publicatieDatum' => date('Y-m-d'),
            'productAanwezig' => (bool) $this->getEnrichment('product_present', false),
            'catalogus' => $this->getEnrichment('catalogus', ''),
            'doelgroep' => $this->getEnrichment('audience', Doelgroep::TYPE_CITIZEN),
            'productValtOnder' => [
                'upnUri' => $this->getMeta('_owc_pdc_upl_resource', ''),
            ],
            'verantwoordelijkeOrganisatie'  => [
                'owmsIdentifier' => 'http://standaarden.overheid.nl/owms/terms/Vereniging_van_Nederlandse_Gemeenten',
            ],
            'locatoes' => null,
            'translations'  => $this->getTranslations(),
        ];

        return new EnrichmentProduct($data);
    }

    protected function getMeta(string $name)
    {
        return \get_post_meta($this->post->ID, $name, true);
    }

    protected function getEnrichment(string $name, $default = null)
    {
        $name = 'enrichment_' . $name;

        return $this->enrichment[$name] ?? $default;
    }

    protected function getTranslations()
    {
        // magic be here
    }
}
