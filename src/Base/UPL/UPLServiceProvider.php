<?php

namespace OWC\PDC\Base\UPL;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Base\Support\Traits\RequestUPL;

class UPLServiceProvider extends ServiceProvider
{
    use RequestUPL;

    public function register()
    {
        $this->plugin->loader->addAction('admin_menu', $this, 'addMenuItemUPL', 10, 0);
    }

    public function addMenuItemUPL(): void
    {
        add_menu_page(
            __('UPL', 'pdc-base'),
            'UPL',
            'edit_posts',
            'upl.php',
            [$this, 'UPLPage'],
            'dashicons-admin-tools',
            6
        );

        add_submenu_page(
            'upl.php',
            __('Correct items', 'pdc-base'),
            __('Correct items', 'pdc-base'),
            'edit_posts',
            'upl-correcte-items',
            [$this, 'correctItemsPage']
        );

        add_submenu_page(
            'upl.php',
            __('Incorrect items', 'pdc-base'),
            __('Incorrect items', 'pdc-base'),
            'edit_posts',
            'upl-foutieve-items',
            [$this, 'incorrectItemsPage']
        );
    }

    public function UPLPage()
    {
        require_once 'views/upl-start.php';
    }

    public function incorrectItemsPage()
    {
        (new IncorrectItems($this->getItems(), $this->getOptionsUPL()))->handle();
    }

    public function correctItemsPage()
    {
        (new CorrectItems($this->getItems(), $this->getOptionsUPL()))->handle();
    }

    protected function getItems(): array
    {
        $args = [
            'post_type' => 'pdc-item',
            'post_status' => ['publish', 'draft']
        ];

        $query = new \WP_Query($args);

        if (empty($query->posts)) {
            return [];
        }

        return $query->posts;
    }
}
