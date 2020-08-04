<?php

namespace OWC\PDC\Base\Repositories;

/**
 * repository for the item
 */
class Item extends AbstractRepository
{
    const PREFIX = '_owc_';

    /**
     * Type of repository.
     *
     * @var string $posttype
     */
    protected $posttype = 'pdc-item';

    /**
     * Container with fields, associated with this repository.
     *
     * @var array $globalFields
     */
    protected static $globalFields = [];
}
