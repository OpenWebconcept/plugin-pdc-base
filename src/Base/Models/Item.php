<?php

namespace OWC\PDC\Base\Models;

/**
 * Model for the item
 */
class Item
{
    const PREFIX = '_owc_';

    /**
     * Type of model.
     *
     * @var string $posttype
     */
    protected $posttype = 'pdc-item';

    /**
     * Data of the Post.
     *
     * @var array
     */
    protected $data;

    /**
     * Metadata of the post.
     *
     * @var array
     */
    protected $meta;

    /**
     * Post constructor.
     *
     * @param array      $data
     * @param array|null $meta
     */
    public function __construct(array $data, array $meta = null)
    {
        $this->data = $data;
        $this->meta = is_null($meta) ? get_post_meta($data['ID']) : $meta;
    }

    /**
     * Make Post model from WP_Post object
     *
     * @param \WP_Post $post
     * @return Post
     */
    public static function makeFrom(\WP_Post $post)
    {
        return new static($post->to_array());
    }

    /**
     * Get the ID of the post.
     *
     * @return int
     */
    public function getID(): int
    {
        return $this->data['ID'] ?? 0;
    }

    /**
     * Get the title of the post.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->data['post_title'];
    }

    /**
     * Get the title of the post.
     *
     * @return string
     */
    public function getPostName(): string
    {
        return $this->data['post_name'];
    }

    /**
     * Get the date of the post as a DateTime object.
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d g:i:s', get_the_date('Y-m-d g:i:s', $this->getID()));
    }

    /**
     * Get the modified date of the post as a DateTime object.
     *
     * @return \DateTime
     */
    public function getPostModified($gmt = false): \DateTime
    {
        $timezone = $gmt ? 'post_modified_gmt' : 'post_modified';

        return (false !== \DateTime::createFromFormat('Y-m-d G:i:s', $this->data[$timezone])) ? \DateTime::createFromFormat('Y-m-d G:i:s', $this->data[$timezone]) : new \DateTime();
    }

    /**
     * Retrieve the date in localized format.
     *
     * @param string $format
     *
     * @return string
     */
    public function getDateI18n(string $format): string
    {
        return date_i18n($format, $this->getDate()->getTimestamp());
    }

    /**
     * Returns the type of the post.
     *
     * @return string|false
     */
    public function getPostType(): string
    {
        return get_post_type($this->getID());
    }

    /**
     * Get the permalink to the post.
     *
     * @return string
     */
    public function getLink(): string
    {
        return get_permalink($this->getID()) ?? '';
    }

    /**
     * Get the thumbnail URL of the author.
     *
     * @param string $size
     *
     * @return string
     */
    public function getThumbnail($size = 'post-thumbnail'): string
    {
        return get_the_post_thumbnail_url($this->getID(), $size) ?? '';
    }

    /**
     * Determines if the post has a thumbnail
     *
     * @return bool
     */
    public function hasThumbnail(): bool
    {
        return has_post_thumbnail($this->getID());
    }

    /**
     * Get the excerpt of the post, else fallback to the post content.
     *
     * @return string
     */
    public function getExcerpt($length = 20): string
    {
        if (empty($this->getKey('post_excerpt'))) {
            return wp_trim_words(strip_shortcodes($this->getKey('post_content')), $length);
        }

        return $this->getKey('post_excerpt');
    }

    /**
     * Get the content of the post.
     *
     * @return string
     */
    public function getContent(): string
    {
        return apply_filters('the_content', $this->getKey('post_content'));
    }

    /**
     * Determines if the post has content.
     *
     * @return bool
     */
    public function hasContent(): bool
    {
        return !empty($this->getKey('post_content'));
    }

    /**
     * Get the taxonomies of a post.
     *
     * @return array
     */
    public function getTaxonomies(): array
    {
        return get_post_taxonomies($this->getID());
    }

    /**
     * Get the terms of a particular taxonomy.
     *
     * @param string $taxonomy
     *
     * @return \WP_Term[]
     */
    public function getTerms(string $taxonomy)
    {
        return get_the_terms($this->getID(), $taxonomy);
    }

    /**
     * Get a particular key from the data.
     *
     * @param string $value
     * @param string $default
     *
     * @return mixed
     */
    protected function getKey(string $value, string $default = '')
    {
        return $this->data[$value] ?? $default;
    }

    /**
     * Get a meta value from the metadata.
     *
     * @param string $value
     * @param string $default
     * @param bool   $single
     * @param null|string $prefix
     *
     * @return mixed
     */
    public function getMeta(string $value, $default = '', $single = true, $prefix = null)
    {
        $prefix = is_null($prefix) ? self::PREFIX : $prefix . $value;

        if (empty($this->meta[$prefix])) {
            return $default;
        }

        return $single ? current($this->meta[$prefix]) : $this->meta[$prefix];
    }

    public function getEscapeElement(): bool
    {
        return $this->getMeta('escape_element_active', '0', true, '_owc_');
    }

    /**
     * URL contains ONLY a connected theme and subtheme.
     * Is used in 'post_type_link' filter registered in '\OWC\PDC\Base\Admin\AdminServiceProvider::class'.
     */
    public function getBasePortalURL(): string
    {
        return PortalLinkGenerator::make($this)->generateBasePortalLink();
    }

    /**
     * URL contains connected theme, connected subtheme, post slug and ID.
     */
    public function getPortalURL(): string
    {
        return PortalLinkGenerator::make($this)->generateFullPortalLink();
    }

    public function getConnected($connection): ?\WP_Post
    {
        $connected = new \WP_Query([
            'connected_type'  => $connection,
            'connected_items' => $this->getID(),
            'nopaging'        => true,
            'post_status'     => 'publish',
            'connected_query' => ['post_status' => ['publish', 'draft']]
        ]);

        return !empty($connected->post) ? $connected->post : null;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public function arrayUnique($array): array
    {
        return is_array($array) ?  array_unique($array) : [];
    }
}
