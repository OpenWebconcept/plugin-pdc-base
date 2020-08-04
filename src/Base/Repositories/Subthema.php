<?php

namespace OWC\PDC\Base\Repositories;

/**
 * Repository for the subthema (category)
 */
class Subthema extends AbstractRepository
{

    /**
     * Type of repository.
     *
     * @var string $posttype
     */
    protected $posttype = 'pdc-subcategory';

    /**
     * Container with fields, associated with this repository.
     *
     * @var array $globalFields
     */
    protected static $globalFields = [];
}
