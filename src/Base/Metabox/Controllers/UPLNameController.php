<?php

namespace OWC\PDC\Base\Metabox\Controllers;

class UPLNameController
{
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getOptions(): array
    {
        return $this->prepareOptions($this->options);
    }

    protected function prepareOptions(array $options): array
    {
        // Prepare options array.
        $options = array_map(function ($item) {
            return $item['UniformeProductnaam']['value'] ?? '';
        }, $options);

        // Remove empty elements.
        return array_map(function ($item) {
            return ['value' => $item, 'label' => ucfirst($item)];
        }, array_unique($options));
    }
}
