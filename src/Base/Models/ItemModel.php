<?php

namespace OWC\PDC\Base\Models;

use WP_Post;
use WP_Query;

class ItemModel
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
     * Additional fields that needs to be added to an item.
     *
     * @var CreatesFields[]
     */
    protected static $fields = [];

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
     * Adds a new field to the
     *
     * @param string        $key
     * @param CreatesFields $creator
     *
     * @return void
     */
    public static function addField(string $key, CreatesFields $creator)
    {
        static::$fields[$key] = $creator;
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
        $response = [
            'id'      => $post->ID,
            'title'   => $post->post_title,
            'content' => $post->post_content,
            'excerpt' => $post->post_excerpt,
            'date'    => $post->post_date
        ];

        // Make metadata present for additional fields
        $response['meta'] = get_post_meta($post->ID);

        foreach (static::$fields as $key => $creator) {
            if ( ! in_array($key, $this->hidden)) {
                $response[$key] = $creator->create($response);
            }
        }

        // Remove the meta key once all additional fields are created.
        unset($response['meta']);

        return $response;
    }

}
