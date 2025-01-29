<?php

namespace OWC\PDC\Base\Taxonomy;

class TaxonomyController
{
    /**
     * Add 'show on' additional explanation.
     *
     * @param string $taxonomy
     *
     * @return void
     */
    public static function addShowOnExplanation(string $taxonomy): void
    {
        if ('pdc-show-on' !== $taxonomy) {
            return;
        }

        echo '<div class="form-field">
            <h3>' . __('Additional explanation', 'pdc-base') . '</h3>
            <p>' . __('The slug value must be the ID of the blog you want to add as term. The ID is used for displaying the correct OpenPDC Items on every blog.', 'pdc-base') . '</p>
            </div>';
    }
}
