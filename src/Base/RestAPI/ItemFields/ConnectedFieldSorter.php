<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use Closure;
use DateTime;

class ConnectedFieldSorter
{
    const DIRECTION_ASC = 'ASC';
    const DIRECTION_DESC = 'DESC';

    const SORTING_TYPE_INT = 'int';
    const SORTING_TYPE_DATE = 'date';
    const SORTING_TYPE_STRING = 'string';

    const SORTING_FIELD_TYPE_ID = 'id';
    const SORTING_FIELD_TYPE_TITLE = 'title';
    const SORTING_FIELD_TYPE_SLUG = 'slug';
    const SORTING_FIELD_TYPE_EXCERPT = 'excerpt';
    const SORTING_FIELD_TYPE_DATE = 'date';

    protected array $items;
    protected string $type = self::SORTING_TYPE_STRING;
    protected string $direction = self::DIRECTION_ASC;

    public function __construct(array $items, string $direction = self::DIRECTION_ASC)
    {
        $this->items = $items;

        $this->setDirection($direction);
    }

    public function setDirection(string $direction): self
    {
        if (! in_array($direction, [static::DIRECTION_ASC, static::DIRECTION_DESC])) {
            throw InvalidSortingArgumentError::makeInvalidDirectionError($direction);
        }

        $this->direction = $direction;

        return $this;
    }

    public function setType(string $type): self
    {
        $allowedTypes = [static::SORTING_TYPE_STRING, static::SORTING_TYPE_INT, static::SORTING_TYPE_DATE];

        if (! in_array($type, $allowedTypes)) {
            throw InvalidSortingArgumentError::makeInvalidTypeError($type);
        }

        $this->type = $type;

        return $this;
    }

    public function sortByKey(string $key): array
    {
        $allowedFieldTypes = [static::SORTING_FIELD_TYPE_ID, static::SORTING_FIELD_TYPE_TITLE, static::SORTING_FIELD_TYPE_SLUG, static::SORTING_FIELD_TYPE_EXCERPT, static::SORTING_FIELD_TYPE_DATE];

        if (! in_array($key, $allowedFieldTypes)) {
            throw InvalidSortingArgumentError::makeInvalidTypeError($key);
        }

        $items = $this->items;

        usort($items, function ($itemA, $itemB) use ($key) {
            $compared = call_user_func(
                $this->getSortingCallback(),
                ($itemA[$key] ?? ''),
                ($itemB[$key] ?? '')
            );

            // Maybe replace with a nicer solution than a nested ternary expression
            return $compared ?
                ($this->direction === static::DIRECTION_ASC ? -1 : 1) :
                ($this->direction === static::DIRECTION_ASC ? 1 : -1);
        });

        return $items;
    }

    protected function getSortingCallback(): Closure
    {
        switch ($this->type) {
            case static::SORTING_TYPE_STRING:
                return fn($valueA, $valueB) => strcmp($valueA, $valueB);
            case static::SORTING_TYPE_INT:
                return fn($valueA, $valueB) => $valueA < $valueB;
            case static::SORTING_TYPE_DATE:
                return fn($valueA, $valueB) => new DateTime($valueA) < new DateTime($valueB);
            default:
                return fn($valueA, $valueB) => strcmp($valueA, $valueB);
        }
    }
}
