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
        return $this->data[$this->identifier . 'active'] ?? false;
    }

    public function getButtonTitle(): string
    {
        return esc_attr($this->data[$this->identifier . 'button_title']) ?? '';
    }

    public function getButtonURL(): string
    {
        return esc_url($this->data[$this->identifier . 'button_url']) ?? '';
    }

    public function getDescription(): string
    {
        return apply_filters('the_content', $this->data[$this->identifier . 'descriptive_text']) ?? '';
    }

    public function getOrder(): int
    {
        return absint(esc_attr($this->data[$this->identifier . 'order'])) ?? 100;
    }
}
