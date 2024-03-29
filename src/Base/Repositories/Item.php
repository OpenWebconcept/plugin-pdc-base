<?php

namespace OWC\PDC\Base\Repositories;

/**
 * repository for the item
 */
class Item extends AbstractRepository
{
    public const PREFIX = '_owc_';

    /**
     * Type of repository.
     *
     * @var string
     */
    protected $posttype = 'pdc-item';

    /**
     * Container with fields, associated with this repository.
     *
     * @var array
     */
    protected static $globalFields = [];
}
