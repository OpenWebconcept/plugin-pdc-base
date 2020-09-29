<?php

/**
 * Model for the group (category)
 */

namespace OWC\PDC\Base\Repositories;

/**
 * Model for the subthema (category)
 */
class Group extends AbstractRepository
{

    /**
     * Type of model.
     *
     * @var string $posttype
     */
    protected $posttype = 'pdc-group';

    /**
     * Container with fields, associated with this model.
     *
     * @var array $globalFields
     */
    protected static $globalFields = [];
}
