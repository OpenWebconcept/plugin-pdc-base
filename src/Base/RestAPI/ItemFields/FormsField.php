<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

class FormsField extends CreatesFields
{

    /**
     * Generate the forms field.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        return array_map(function ($form) {
            return [
                'title' => esc_attr(strip_tags($form['pdc_forms_title'])),
                'url'   => esc_url($form['pdc_forms_url'])
            ];
        }, $this->getForms($post));
    }

    /**
     * Get forms of a post, if URL & title are present.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    private function getForms(WP_Post $post)
    {
        return array_filter(get_post_meta($post->ID, '_owc_pdc_forms_group', true) ?: [], function ($form) {
            return ! empty($form['pdc_forms_url']) && ! empty($form['pdc_forms_title']);
        });
    }

}