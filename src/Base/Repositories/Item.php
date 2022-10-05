<?php

namespace OWC\PDC\Base\Repositories;

use WP_Post;

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

    /**
     * Transform a single WP_Post item.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function transform(WP_Post $post)
    {
        $data = [
            'id'          => $post->ID,
            'title'       => $post->post_title,
            'slug'        => $post->post_name,
            'content'     => $this->isAllowed($post) ? apply_filters('the_content', $post->post_content) : "",
            'excerpt'     => $this->isAllowed($post) ? $post->post_excerpt : "",
            'date'        => $post->post_date,
            'slug'        => $post->post_name,
            'post_status' => $post->post_status,
            'protected'   => ! $this->isAllowed($post)
        ];

        $data = $this->assignFields($data, $post);

        return $this->getPreferredFields($data);
    }
}
