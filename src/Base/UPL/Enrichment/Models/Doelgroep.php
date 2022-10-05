<?php

namespace OWC\PDC\Base\UPL\Enrichment\Models;

use InvalidArgumentException;

class Doelgroep
{
    const TYPE_CITIZEN = 'eu-burger';
    const TYPE_COMPANY = 'eu-bedrijf';

    const LABEL_CITIZEN = 'Burger';
    const LABEL_COMPANY = 'Bedrijf';

    protected string $group;

    public function __construct(string $group)
    {
        if (! in_array($group, [self::TYPE_CITIZEN, self::TYPE_COMPANY])) {
            throw new InvalidArgumentException("Unknown group '{$group}'");
        }

        $this->group = $group;
    }

    public function __toString(): string
    {
        return $this->get();
    }

    public function get(): string
    {
        return $this->group;
    }

    public function isCitizen(): bool
    {
        return $this->group === self::TYPE_CITIZEN;
    }

    public function isCompany(): bool
    {
        return $this->group === self::TYPE_COMPANY;
    }
}
