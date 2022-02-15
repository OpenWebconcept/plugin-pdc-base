<?php declare(strict_types=1);

namespace OWC\PDC\Base\Support\Traits;

trait CheckPluginActive
{
    /**
     * @param string $file // example: 'pdc-internal-products/pdc-internal-products.php'
     */
    public function isPluginActive(string $file): bool
    {
        if (! function_exists('is_plugin_active')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return is_plugin_active($file);
    }

    public function isPluginPDCInternalProductsActive(): bool
    {
        return $this->isPluginActive('pdc-internal-products/pdc-internal-products.php');
    }
}
