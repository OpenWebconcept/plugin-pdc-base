<?php declare(strict_types=1);

namespace OWC\PDC\Base\Repositories;

/**
 * Repository for the thema (category)
 */
class Thema extends AbstractRepository
{

    /**
     * Type of repository.
     *
     * @var string
     */
    protected $posttype = 'pdc-category';

    /**
     * Container with fields, associated with this repository.
     *
     * @var array
     */
    protected static $globalFields = [];
}
