<?php declare(strict_types=1);

namespace OWC\PDC\Base\UPL;

class CorrectItems extends UPL
{
    public function handle()
    {
        $this->validateUPLNames();
        $this->prepareItems();
        $correctItems = $this->compareCorrectItems();

        require_once 'views/generate-upl-success-list.php';
    }

    public function compareCorrectItems(): array
    {
        return array_filter($this->items, function ($item) {
            return $this->compareCorrectItem($item);
        });
    }

    protected function compareCorrectItem($item): bool
    {
        foreach ($this->uplOptions as $option) {
            if (strtolower($option['UniformeProductnaam']['value']) !== $item['uplName'] || strtolower($item['uplUrl']) !== strtolower($option['URI']['value'])) {
                continue;
            }

            return true;
        }

        return false;
    }
}
