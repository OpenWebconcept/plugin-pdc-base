<?php

/**
 * Adds download fields to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds download fields to the output.
 */
class IdentificationsField extends CreatesFields
{
    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return $this->plugin->settings->useIdentifications();
        };
    }

    /**
     * Create the identifications field for a given post.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $identifications = [];

        $identifications['digid']       = $this->createField($post, '_owc_digid-group', 'digid_');
        $identifications['eherkenning'] = $this->createField($post, '_owc_eherkenning-group', 'eherkenning_');
        $identifications['eidas']       = $this->createField($post, '_owc_eidas-group', 'eidas_');
        $identifications['general']     = $this->createField($post, '_owc_general_identification-group', 'general_identification_');

        return $identifications;
    }

    /**
     * Create API field
     *
     * @param WP_Post $post
     * @param string $groupIdentifier
     * @param string $identifier
     * @return array
     */
    private function createField(WP_Post $post, string $groupIdentifier, string $identifier): array
    {
        $group = get_post_meta($post->ID, $groupIdentifier);

        if (empty($group)) {
            return [];
        }

        return $this->createData($group, $identifier);
    }

    /**
     * Create data for API field
     *
     * @param array $group
     * @param string $identifier
     * @return array
     */
    private function createData(array $group, string $identifier): array
    {
        $identifications = [];

        foreach ($group[0] as $groupItem) {
            if (empty($groupItem)) {
                continue;
            }

            $identification = new \OWC\PDC\Base\Models\Identification($identifier, $groupItem);

            if ($identification->isActive()) {
                $identifications[] = [
                    'title'       => $identification->getButtonTitle(),
                    'url'         => $identification->getButtonURL(),
                    'description' => $identification->getDescription(),
                    'order'       => $identification->getOrder(),
                ];
            }
        }

        return $identifications;
    }
}
