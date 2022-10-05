<?php

namespace OWC\PDC\Base\UPL\Enrichment;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\UPL\Enrichment\Commands\EnrichmentItemsPDC;
use OWC\PDC\Base\UPL\Enrichment\Controllers\Push as PushController;
use OWC\PDC\Base\UPL\Enrichment\Services\EnrichmentProductResolver;

class EnrichmentServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!$this->plugin->settings->useEnrichment()) {
            return;
        }

        /**
         * Temporary test method
         */
        // $this->test();

        $this->plugin->loader->addAction('wp_dashboard_setup', $this, 'latestEnrichments', 10, 2);
        $this->plugin->loader->addAction('admin_enqueue_scripts', $this, 'registerStyle', 10, 0);

        if ($this->plugin->settings->enableInputFacility()) {
            $this->plugin->loader->addAction('wp_after_insert_post', new PushController(), 'handlePush', 10, 4);
        }

        if (class_exists('\WP_CLI')) {
            \WP_CLI::add_command('owc-enrichment-pdc-items', [EnrichmentItemsPDC::class, 'execute'], ['shortdesc' => 'Enrich PDC-items.']);
        }
    }

    /**
     * Temporary test method
     */
    protected function test(): void
    {
        // Resolved product

        /*
        $pushObject = new EnrichmentProductResolver(get_post(2819));
        var_dump($pushObject->resolve()->jsonSerialize());
        die; */


        // Resolved product result of post request

        /*
        $pushObject = new EnrichmentProductResolver(get_post(2819));
        $result = wp_remote_post($this->plugin->settings->getInputFacilityBaseApiURL() . 'producten', [
            'headers' => [
                'Authorization' => 'Token ' . $this->plugin->settings->getInputFacilityApiToken(),
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($pushObject->resolve()->jsonSerialize())
        ]);
        var_dump($result);
        die;*/
    }

    public function latestEnrichments(): void
    {
        \wp_add_dashboard_widget('dashboard_owc_latest_enrichments', __('Recent enrichments', 'pdc-base'), [(new DashboardWidget()), 'dashboardOutput']);
    }

    public function registerStyle(): void
    {
        wp_register_style('admin_css', $this->plugin->getPluginUrl() . '/assets/css/admin.css', [], false);
        wp_enqueue_style('admin_css');
    }
}
