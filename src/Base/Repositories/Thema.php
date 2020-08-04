<?php

namespace OWC\PDC\Base\Repositories;

/**
 * Repository for the thema (category)
 */
class Thema extends AbstractRepository
{

    /**
     * Type of repository.
     *
     * @var string $posttype
     */
    protected $posttype = 'pdc-category';

    /**
     * Container with fields, associated with this repository.
     *
     * @var array $globalFields
     */
    protected static $globalFields = [];
}
