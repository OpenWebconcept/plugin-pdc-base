<?php

namespace OWC\PDC\Base\RestAPI\SharedFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

class AuthorField extends CreatesFields
{
    public function create(WP_Post $post): ?int
    {
        return isset($post->post_author) ? (int) $post->post_author : null;
    }
}
