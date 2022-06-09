<?php

namespace OWC\PDC\Base\Models;

class EnrichmentProduct 
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getLabel()
    {
        return $this->data['upnLabel'] ?? '';
    }

    public function getURI()
    {
        return $this->data['upnUri'] ?? '';
    }

    public function getVersion()
    {
        return $this->data['versie'] ?? '';
    }

    public function getTranslations(): array
    {
        $translations = $this->data['vertalingen'] ?? [];

        return array_map(function($translation){
            return new Translation($translation);
        }, $translations);
    }
}