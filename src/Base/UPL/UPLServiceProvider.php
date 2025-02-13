<?php

namespace OWC\PDC\Base\UPL;

use OWC\PDC\Base\Support\Traits\RequestUPL;
use OWC\PDC\Base\Foundation\ServiceProvider;

class UPLServiceProvider extends ServiceProvider
{
    use RequestUPL;

    public function register()
    {
        $this->plugin->loader->addAction('admin_menu', $this, 'addMenuItemUPL', 10, 0);
    }

    public function addMenuItemUPL(): void
    {
		add_management_page(
			__('UPL Reparatie', 'pdc-base'),
			__('UPL Reparatie', 'pdc-base'),
			'edit_posts',
			'upl-correcte-items',
			[$this, 'correctItemsPage'],
			6
		);

		add_submenu_page(
			'',
			__('Incorrect items', 'pdc-base'),
			__('Incorrect items', 'pdc-base'),
			'edit_posts',
			'upl-foutieve-items',
			[$this, 'incorrectItemsPage']
		);
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
