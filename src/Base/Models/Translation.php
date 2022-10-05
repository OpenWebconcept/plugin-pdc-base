<?php

namespace OWC\PDC\Base\Models;

class Translation
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getLanguage(): string
    {
        return $this->data['taal'] ?? '';
    }

    public function getNationalText(): string
    {
        return $this->data['specifiekeTekst'] ?? '';
    }

    public function getExampleTextSDG(): string
    {
        $procedureDescription = $this->data['procedureBeschrijving'] ?? '';

        if (empty($procedureDescription)) {
            return '';
        }

        if (! class_exists('Parsedown')) {
            return $procedureDescription;
        }

        return (new \Parsedown())->text($procedureDescription);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
