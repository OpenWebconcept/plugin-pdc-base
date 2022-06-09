<?php 

namespace OWC\PDC\Base\UPL\Enrichment;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\UPL\Enrichment\Commands\EnrichmentItemsPDC;

class EnrichmentServiceProvider extends ServiceProvider 
{
    public function register()
    {
        if(!$this->plugin->settings->useEnrichment()){
            return;
        }
        
        $this->plugin->loader->addAction('wp_dashboard_setup', $this, 'latestEnrichments', 10, 2);
        $this->plugin->loader->addAction('admin_enqueue_scripts', $this, 'registerStyle', 10, 0);

        if (class_exists('\WP_CLI')) {
            \WP_CLI::add_command('owc-enrichment-pdc-items', [EnrichmentItemsPDC::class, 'execute'], ['shortdesc' => 'Enrich PDC-items.']);
        }
    }

    public function latestEnrichments(): void
    {
        \wp_add_dashboard_widget('dashboard_owc_latest_enrichments', __('Recent enrichments', 'pdc-base'), [(new DashboardWidget), 'dashboardOutput']);
    }

    public function registerStyle(): void
    {
        wp_register_style( 'admin_css', $this->plugin->getPluginUrl() . '/assets/css/admin.css', [], false );
        wp_enqueue_style( 'admin_css' );
    }
}