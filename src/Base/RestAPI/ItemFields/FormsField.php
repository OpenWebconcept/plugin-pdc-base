<?php

/**
 * Adds form fields to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds form fields to the output.
 */
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
            $url = $form['pdc_forms_url'];
            if (empty($form['pdc_forms_url'])) {
                $url = do_shortcode($form['pdc_forms_shortcode']);
            }

            return [
                'title'    => esc_attr(strip_tags($form['pdc_forms_title'])),
                'url'      => esc_url($url),
                'filesize' => $this->getFileSize($url)
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
            return (!empty($form['pdc_forms_url']) or !empty($form['pdc_forms_shortcode'])) && (!empty($form['pdc_forms_title']));
        });
    }
}
