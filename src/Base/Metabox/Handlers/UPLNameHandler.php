<?php

namespace OWC\PDC\Base\Metabox\Handlers;

class UPLNameHandler
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
        $options = array_filter(array_unique($options), function ($item) {
            return !empty($item);
        });

        // Return prepared options.
        return array_map(function ($item) {
            return ['value' => $item, 'label' => ucfirst($item)];
        }, $options);
    }
}
