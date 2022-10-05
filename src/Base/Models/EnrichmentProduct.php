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

    public function getPublicationDate(): ?DateTime
    {
        try {
            return DateTime::createFromFormat(
                'Y-m-d',
                $this->getDataAttribute('publicatieDatum')
            );
        } catch (\TypeError | \Exception $e) {
            return null;
        }
    }

    public function getCatalogus(): string
    {
        return $this->getDataAttribute('catalogus', '');
    }

    public function getAudience(): string
    {
        // return new Doelgroep($this->getDataAttribute('doelgroep', ''));
        return $this->getDataAttribute('doelgroep', '');
    }

    public function setAudience(Doelgroep $doelgroep): self
    {
        $this->data['doelgroep'] = $doelgroep->get();

        return $this;
    }

    public function getProductPresent(): ?string
    {
        $value = $this->getDataAttribute('productAanwezig');

        if (is_null($value)) {
            return 'null';
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
    }

    public function setProductPresent(bool $present): self
    {
        $this->data['productAanwezig'] = $present;

        return $this;
    }

    public function getProductBelongsTo(): ?array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('productValtOnder', null);
    }

    public function getResponsibleOrganization(): array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('verantwoordelijkeOrganisatie', []);
    }

    public function getQualifiedOrganization(): array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('bevoegdeOrganisatie', []);
    }

    public function getLocations(): array
    {
        // Maybe transform to complex data type
        return $this->getDataAttribute('locaties', []);
    }

    public function getTranslations(): array
    {
        $translations = $this->getDataAttribute('vertalingen', []);

        return array_map(function ($translation) {
            return new Translation($translation);
        }, $translations);
    }

    public function getAvailableLanguages(): array
    {
        return $this->getDataAttribute('beschikbareTalen', []);
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
