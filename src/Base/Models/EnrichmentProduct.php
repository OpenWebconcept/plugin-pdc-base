<?php

namespace OWC\PDC\Base\Models;

use DateTime;
use JsonSerializable;
use OWC\PDC\Base\UPL\Enrichment\Models\Doelgroep;

class EnrichmentProduct implements JsonSerializable
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get(string $name)
    {
        return $this->getDataAttribute($name, null);
    }

    public function __set(string $name, $value)
    {
        return $this->setDataAttribute($name, $value);
    }

    public function getDataAttribute(string $name, $default = null)
    {
        return $this->data[$name] ?? $default;
    }

    public function setDataAttribute(string $name, $value): self
    {
        if (method_exists($this, 'set' . ucwords($name))) {
            return $this->{'set' . $name}($value);
        }

        $this->data[$name] = $value;

        return $this;
    }

    public function getUrl(): string
    {
        return (string) $this->getDataAttribute('url', '');
    }

    public function getUuid(): string
    {
        return (string) $this->getDataAttribute('uuid', '');
    }

    public function getLabel(): string
    {
        return (string) $this->getDataAttribute('upnLabel', '');
    }

    public function getURI(): string
    {
        return (string) $this->getDataAttribute('upnUri', '');
    }

    public function getVersion(): ?int
    {
        return $this->getDataAttribute('versie', 0);
    }

    public function getPublicatieDatum(): ?DateTime
    {
        try {
            return DateTime::createFromFormat(
                'Y-m-d',
                $this->getDataAttribute('publicatieDatum')
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getCatalogus(): string
    {
        return $this->getDataAttribute('catalogus', '');
    }

    public function getDoelgroep(): Doelgroep
    {
        return new Doelgroep($this->getDataAttribute('doelgroep', ''));
    }

    public function setDoelgroep(Doelgroep $doelgroep): self
    {
        $this->data['doelgroep'] = $doelgroep->get();

        return $this;
    }

    public function getProductAanwezig(): string
    {
        $value =  $this->getDataAttribute('productAanwezig', false);

        return filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
    }

    public function setProductAanwezig(bool $aanwezig): self
    {
        $this->data['productAanwezig'] = $aanwezig;

        return $this;
    }

    public function getProductValtOnder(): array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('productValtOnder', []);
    }

    public function getVerantwoordelijkeOrganisatie(): array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('verantwoordelijkeOrganisatie', []);
    }

    public function getBevoegdeOrganisatie(): array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('bevoegdeOrganisatie', []);
    }

    public function getLocaties(): array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('locaties', []);
    }

    public function getTranslations(): array
    {
        $translations = $this->data['vertalingen'] ?? [];

        return array_map(function ($translation) {
            return new Translation($translation);
        }, $translations);
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
