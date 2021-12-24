<?php

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
            if (empty($item['uplNames'])) {
                return false;
            }

            return $this->compareCorrectItem($item);
        });
    }

    protected function compareCorrectItem($item): bool
    {
        $total = count($item['uplNames']);
        $counter = 0;
        foreach ($item['uplNames'] as $uplName) {
            foreach ($this->uplOptions as $option) {
                if ($uplName !== strtolower($option['UniformeProductnaam']['value'])) {
                    continue;
                }

                $counter = $counter + 1;
                break;
            }
        }

        if ($total !== $counter) {
            return false;
        }

        return true;
    }
}
