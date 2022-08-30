<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use InvalidArgumentException;

class InvalidSortingArgumentError extends InvalidArgumentException
{
    public static function makeInvalidDirectionError(string $invalidDirection): self
    {
        return new static(sprintf(
            __("Invalid sorting direction '%s'", 'pdc-base'),
            sanitize_text_field($invalidDirection)
        ));
    }

    public static function makeInvalidTypeError(string $invalidType): self
    {
        return new static(sprintf(
            __("Invalid sorting type '%s'", 'pdc-base'),
            sanitize_text_field($invalidType)
        ));
    }
}
