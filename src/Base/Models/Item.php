<?php

namespace OWC\PDC\Base\Models;

use WP_Post;
use WP_Query;
use OWC\PDC\Base\Support\CreatesFields;

class Item
{

    protected $posttype = 'pdc-item';

    /**
     * Arguments for the WP_Query
     *
     * @var array
     */
    protected $query = [];

    /**
     * Fields that need to be hidden.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Dynamically added fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Additional fields that needs to be added to an item.
     *
     * @var CreatesFields[]
     */
    protected static $globalFields = [];

    /**
     * Get all the items from the database.
     *
     * @return array
     */
    public function all(): array
    {
        $args = array_merge($this->query, [
            'post_type' => [ $this->posttype ]
        ]);

        return array_map([ $this, 'transform' ], (new WP_Query($args))->posts);
    }

    /**
     * Find a particular pdc item by ID.
     *
     * @param int $id
     *
     * @return array|null
     */
    public function find(int $id)
    {
        $query = (new WP_Query([
            'p'         => $id,
            'post_type' => [ $this->posttype ]
        ]));

        if (empty($query->posts)) {
            return null;
        }

        return $this->transform(reset($query->posts));
    }

    /**
     * Add additional query arguments.
     *
     * @param array $args
     *
     * @return $this
     */
    public function query(array $args)
    {
        $this->query = array_merge($this->query, $args);

        return $this;
    }

    /**
     * Hide a particular key from the request.
     *
     * @param array $keys
     *
     * @return $this
     */
    public function hide(array $keys)
    {
        $this->hidden = array_merge($this->hidden, $keys);

        return $this;
    }

    /**
     * Dynamically add additional fields to the model.
     *
     * @param string        $key
     * @param CreatesFields $creator
     *
     * @return $this
     */
    public function addField(string $key, CreatesFields $creator)
    {
        $this->fields[$key] = $creator;

        return $this;
    }

    /**
     * Adds a new field to the
     *
     * @param string        $key
     * @param CreatesFields $creator
     *
     * @return void
     */
    public static function addGlobalField(string $key, CreatesFields $creator)
    {
        static::$globalFields[$key] = $creator;
    }

    /**
     * Transform a single WP_Post item.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    protected function transform(WP_Post $post)
    {
        $result = [
            'id'      => $post->ID,
            'title'   => $post->post_title,
            'content' => $post->post_content,
            'excerpt' => $post->post_excerpt,
            'date'    => $post->post_date
        ];

        // Assign global fields.
        foreach (static::$globalFields as $key => $creator) {
            if ( ! in_array($key, $this->hidden)) {
                $result[$key] = $creator->create($post);
            }
        }

        // Assign dynamic fields.
        foreach ($this->fields as $key => $creator) {
            $result[$key] = $creator->create($post);
        }

        return $result;
    }

}
