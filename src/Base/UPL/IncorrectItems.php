<?php

namespace OWC\PDC\Base\UPL;

class IncorrectItems extends UPL
{
    public function handle()
    {
        $this->validateUPLNames();
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
        $total = count($item['uplNames']);
        $counter = 0;

        foreach ($item['uplNames'] as $uplName) {
            foreach ($this->uplOptions as $option) {
                if ($uplName === strtolower($option['UniformeProductnaam']['value'])) {
                    $counter = $counter + 1;
                    break;
                }
            }
        }

        if ($total === $counter) {
            return false;
        }

        return true;
    }
}
