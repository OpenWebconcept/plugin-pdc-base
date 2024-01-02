<?php

namespace OWC\PDC\Base\UPL;

class IncorrectItems extends UPL
{
    public function handle()
    {
        $this->prepareItems();
        $incorrectItems = $this->compareIncorrectItems();

        require_once 'views/generate-upl-error-list.php';
    }

    public function compareIncorrectItems(): array
    {
        return array_filter($this->items, function ($item) {
            return $this->compareIncorrectItem($item);
        });
    }

    protected function compareIncorrectItem($item): bool
    {
        foreach ($this->uplOptions as $option) {
            if ($option['UniformeProductnaam']['value'] === $item['uplName'] && strtolower($item['uplUrl']) === strtolower($option['URI']['value'])) {
                return false;
            }
        }

        return true;
    }
}
