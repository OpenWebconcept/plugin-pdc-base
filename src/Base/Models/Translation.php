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

    public function getSpecificText(): string
    {
        return $this->data['specifiekeTekst'] ?? '';
    }

    public function getProcedureDescription(): string
    {
        return $this->data['procedureBeschrijving'] ?? '';
    }
}