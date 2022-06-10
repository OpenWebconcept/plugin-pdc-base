<?php

namespace OWC\PDC\Base\Models;

class Identification
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * Data of the Identification.
     *
     * @var array
     */
    protected $data;

    /**
     * Identification constructor.
     *
     * @param string $identifier
     * @param array $data
     */
    public function __construct(string $identifier, array $data)
    {
        $this->identifier = $identifier;
        $this->data       = $data;
    }

    public function isActive(): bool
    {
        return $this->data[sprintf('%s_active', $this->identifier)] ?? false;
    }

    public function getButtonTitle(): string
    {
        $title = $this->data[sprintf('%s_button_title', $this->identifier)] ?? '';
        return esc_attr($title);
    }

    public function getButtonURL(): string
    {
        $url = $this->data[sprintf('%s_button_url', $this->identifier)] ?? '';
        return esc_url($url);
    }

    public function getDescription(): string
    {
        $description = $this->data[sprintf('%s_descriptive_text', $this->identifier )] ?? '';
        return apply_filters('the_content', $description);
    }

    public function getOrder(): int
    {
        $order = $this->data[sprintf('%s_order', $this->identifier)] ?? 100;
        return absint(esc_attr($order));
    }
}
