<?php

/**
 * Adds featured image to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds featured image to the output.
 */
class FeaturedImageField extends CreatesFields
{
    /**
     * Gets the featured image of a post.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        if (!has_post_thumbnail($post->ID)) {
            return [];
        }

        $attachmentID = get_post_thumbnail_id($post->ID);

        // Allow additional actions before creation of featured image.
        do_action('owc/pdc-base/rest-api/shared-items/field/before-creation-featured-image', $post);

        $attachment = get_post($attachmentID);

        if (!$attachment instanceof \WP_Post) {
            return [];
        }

        $imageSize = 'large';
        $result    = [];

        $result['title']       = $attachment->post_title;
        $result['description'] = $attachment->post_content;
        $result['caption']     = $attachment->post_excerpt;
        $result['alt']         = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);

        $meta = $this->getAttachmentMeta($attachmentID);

        $result['rendered'] = wp_get_attachment_image($attachmentID, $imageSize);
        $result['sizes']    = wp_get_attachment_image_sizes($attachmentID, $imageSize, $meta);
        $result['srcset']   = wp_get_attachment_image_srcset($attachmentID, $imageSize, $meta);
        $result['meta']     = $meta;

        // Allow additional actions after creation of featured image.
        do_action('owc/pdc-base/rest-api/shared-items/field/after-creation-featured-image', $post);

        return $result;
    }

    /**
     * Get meta data of an attachment.
     *
     * @param $id
     *
     * @return array
     */
    private function getAttachmentMeta($id): array
    {
        $meta = wp_get_attachment_metadata($id, false);

        if (empty($meta['sizes'])) {
            return [];
        }

        foreach (array_keys($meta['sizes']) as $size) {
            $src                         = wp_get_attachment_image_src($id, $size);
            $meta['sizes'][$size]['url'] = $src[0];
        }

        unset($meta['image_meta']);

        return $meta;
    }
}
