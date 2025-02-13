<?php

namespace OWC\PDC\Base\RestAPI\SharedFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

class HideFeedbackForm extends CreatesFields
{
    public function create(WP_Post $post): bool
    {
        $hide = \get_post_meta($post->ID, '_owc_pdc_hide_feedback_form', true);

        if (empty($hide)) {
            return false;
        }

        return true;
    }
}
