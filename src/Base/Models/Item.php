<?php

namespace OWC\PDC\Base\Models;

use WP_Post;
use DateTime;
use WP_Query;

class Item
{
    public const PREFIX = '_owc_';

    protected string $posttype = 'pdc-item';
    protected array $data;
    protected array $meta;

    public function __construct(array $data, array $meta = null)
    {
        $this->data = $data;
        $this->meta = is_null($meta) ? get_post_meta($data['ID']) : $meta;
    }

    /**
     * @param WP_Post $post
     *
     * @return static
     */
    public static function makeFrom(WP_Post $post)
    {
        return new static($post->to_array());
    }

    public function getID(): int
    {
        return $this->data['ID'] ?? 0;
    }

    public function getTitle(): string
    {
        return $this->data['post_title'] ?? '';
    }

    public function getPostName(): string
    {
        return $this->data['post_name'] ?? '';
    }

    public function getDate(): DateTime
    {
        return DateTime::createFromFormat('Y-m-d g:i:s', get_the_date('Y-m-d g:i:s', $this->getID()));
    }

    public function getPostModified($gmt = false): DateTime
    {
        $timezone = $gmt ? 'post_modified_gmt' : 'post_modified';

        return (false !== DateTime::createFromFormat('Y-m-d G:i:s', $this->data[$timezone])) ? DateTime::createFromFormat('Y-m-d G:i:s', $this->data[$timezone]) : new DateTime();
    }

    public function getDateI18n(string $format): string
    {
        return date_i18n($format, $this->getDate()->getTimestamp());
    }

    public function getPostType(): string
    {
        return get_post_type($this->getID()) ?: '';
    }

    public function getLink(): string
    {
        return get_permalink($this->getID()) ?: '';
    }

    public function getThumbnail(string $size = 'post-thumbnail'): string
    {
        return get_the_post_thumbnail_url($this->getID(), $size) ?: '';
    }

    public function hasThumbnail(): bool
    {
        return has_post_thumbnail($this->getID());
    }

    /**
     * Get the excerpt of the post, else fallback to the post content.
     */
    public function getExcerpt(int $length = 20): string
    {
        if (empty($this->getKey('post_excerpt'))) {
            return wp_trim_words(strip_shortcodes($this->getKey('post_content')), $length);
        }

        return $this->getKey('post_excerpt');
    }

    public function getContent(): string
    {
        return apply_filters('the_content', $this->getKey('post_content'));
    }

    public function hasContent(): bool
    {
        return ! empty($this->getKey('post_content'));
    }

    /**
     * Get the taxonomies of a post.
     */
    public function getTaxonomies(): array
    {
        return get_post_taxonomies($this->getID());
    }

    /**
     * Get the terms of a particular taxonomy.
     */
    public function getTerms(string $taxonomy)
    {
        $terms = get_the_terms($this->getID(), $taxonomy);

        return is_array($terms) ? $terms : [];
    }

    /**
     * Get a particular key from the data.
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
        $value = $this->getMeta('escape_element_active', '0', true, '_owc_');

        return boolval($value);
    }

    public function useTableOfContents(): bool
    {
        $value = $this->getMeta('pdc_use_table_of_contents', '0', true, '_owc_');

        return boolval($value);
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

    public function getConnected($connection, $args = []): ?WP_Post
    {
        $connected = new WP_Query($this->connectedQueryArgs($connection, $args));

        return $connected->post instanceof WP_Post ? $connected->post : null;
    }

    public function getConnectedAll($connection, $args = []): array
    {
        $connected = new WP_Query($this->connectedQueryArgs($connection, $args));

        return $connected->posts;
    }

    protected function connectedQueryArgs(string $connection, array $args = []): array
    {
        return array_merge([
            'connected_type' => $connection,
            'connected_items' => $this->getID(),
            'nopaging' => true,
            'post_status' => 'publish',
            'connected_query' => ['post_status' => ['publish', 'draft']]
        ], $args);
    }

    public function arrayUnique($array): array
    {
        return is_array($array) ? array_unique($array) : [];
    }
}
