<?php

namespace OWC\PDC\Base\UPL\Enrichment\Models;

class Translation
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return $this->data['titel'] ?? '';
    }

    /**
     * Metabox key_value field type does not accept associative keys inside a multidimensional array.
     * Convert to indexed.
     */
    public function links(): array
    {
        $links = $this->data['links'] ?? [];

        if (empty($links)) {
            return [];
        }

        return array_map(function ($link) {
            return [$link['label'], $link['url']];
        }, $links);
    }

    public function language(): string
    {
        return $this->data['taal'] ?? '';
    }

    public function decentralizedProductTitle(): string
    {
        return $this->data['productTitelDecentraal'] ?? '';
    }

    public function nationalText(): string
    {
        return 'This field does not exist in the source yet.';
        // return $this->data['specifiekeTekst'] ?? '';
    }

    public function referenceLinks(): array
    {
        return $this->data['verwijzingLinks'] ?? [];
    }

    public function procedureDesc(): string
    {
        $desc = $this->data['procedureBeschrijving'] ?? '';

        if (empty($desc)) {
            return '';
        }

        if (! class_exists('Parsedown')) {
            return $desc;
        }

        return (new \Parsedown())->text($desc);
    }

    public function proof(): string
    {
        return $this->data['bewijs'] ?? '';
    }

    public function requirements(): string
    {
        return $this->data['vereisten'] ?? '';
    }

    public function objectionAndAppeal(): string
    {
        return $this->data['bezwaarEnBeroep'] ?? '';
    }

    public function costAndPaymentMethods(): string
    {
        $value = $this->data['kostenEnBetaalmethoden'] ?? '';

        if (empty($value)) {
            return '';
        }

        if (! class_exists('Parsedown')) {
            return $value;
        }

        return (new \Parsedown())->text($value);
    }

    public function deadline(): string
    {
        $deadline = $this->data['uitersteTermijn'] ?? '';

        if (empty($deadline)) {
            return '';
        }

        if (! class_exists('Parsedown')) {
            return $deadline;
        }

        return (new \Parsedown())->text($deadline);
    }

    public function actionWhenNoReaction(): string
    {
        return $this->data['wtdBijGeenReactie'] ?? '';
    }

    /**
     * Metabox key_value field type does not accept associative keys inside a multidimensional array.
     * Convert to indexed.
     */
    public function procedureLink(): array
    {
        $link = $this->data['procedureLink'] ?? [];

        return [
            $link['label'],
            $link['url']
        ];
    }

    public function productPresentExplanation(): string
    {
        return $this->data['productAanwezigToelichting'] ?? '';
    }

    public function productBelongsToExplanation(): string
    {
        return $this->data['productValtOnderToelichting'] ?? '';
    }

    public function exampleTextSDG(): string
    {
        $procedureDescription = $this->data['tekst'] ?? '';

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
