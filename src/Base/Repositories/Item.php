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
            'content'     => $this->isAllowed($post) ? apply_filters('the_content', $this->stripSpecificBlock($post)) : "",
            'excerpt'     => $this->isAllowed($post) ? $post->post_excerpt : "",
            'date'        => $post->post_date,
            'slug'        => $post->post_name,
            'post_status' => $post->post_status,
            'protected'   => !$this->isAllowed($post)
        ];

        $data = $this->assignFields($data, $post);

        return $this->getPreferredFields($data);
    }
    
    protected function stripSpecificBlock(WP_Post $post): string
    {
        $showSpecificInAPI = $this->showSpecificTextInApi($post);

        if(! $showSpecificInAPI) {
            return $post->post_content;
        }

        $pattern = '/(<!-- Test specific text -->)/';
        return preg_replace_callback($pattern, function($matches){
            return '';
        }, $post->post_content);
    }

    protected function showSpecificTextInApi(WP_Post $post): bool
    {
        $group = $this->getEnrichmentGroup($post);

        $show = $group['enrichment_specific_show_in_api'] ?? '';

        return $show === '1' ? true : false;
    }

    protected function getEnrichmentGroup(WP_Post $post): array
    {
        $enrichmentGroup = get_post_meta($post->ID, '_owc_enrichment-group', true);
        
        if (empty($enrichmentGroup) || !is_array($enrichmentGroup)){
            return [];
        }

        return $enrichmentGroup;
    }
}
