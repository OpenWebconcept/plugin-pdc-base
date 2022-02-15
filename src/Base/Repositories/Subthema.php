<?php declare(strict_types=1);

namespace OWC\PDC\Base\Repositories;

/**
 * Repository for the subthema (category)
 */
class Subthema extends AbstractRepository
{

    /**
     * Type of repository.
     *
     * @var string
     */
    protected $posttype = 'pdc-subcategory';

    /**
     * Container with fields, associated with this repository.
     *
     * @var array
     */
    protected static $globalFields = [];
}
