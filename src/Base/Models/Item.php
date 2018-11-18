<?php
/**
 * Model for the item
 */

namespace OWC\PDC\Base\Models;

/**
 * Model for the item
 */
class Item extends Model
{

    /**
     * Type of model.
     *
     * @var string $posttype
     */
    protected $posttype = 'pdc-item';

    /**
     * Container with fields, associated with this model.
     *
     * @var array $globalFields
     */
    protected static $globalFields = [];
}
