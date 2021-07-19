<?php

namespace OWC\PDC\Base\Metabox;

use OWC\PDC\Base\Foundation\ServiceProvider;

/**
 * Provider which handles the metabox registration.
 */
abstract class MetaboxBaseServiceProvider extends ServiceProvider
{
    /**
     * Constant prefix for metabox.
     *
     * @var string
     */
    const PREFIX = '_owc_';

    /**
     * Process the metabox array for compatible output.
     *
     * @param array $metabox
     *
     * @return void
     */
    protected function processMetabox(array $metabox)
    {
        $fields = [];
        foreach ($metabox['fields'] as $fieldGroup) {
            $fields = array_merge($fields, $this->processFieldGroup($fieldGroup));
        }
        $metabox['fields'] = $fields;

        return $metabox;
    }

    /**
     * Processes each field group.
     *
     * @param array $fieldGroup
     *
     * @return array
     */
    private function processFieldGroup($fieldGroup)
    {
        $fields = [];
        foreach ($fieldGroup as $field) {
            $fields[] = $this->addPrefix($field);
        }

        return $fields;
    }

    /**
     * Adds prefix to each field.
     *
     * @param array $field
     *
     * @return array
     */
    private function addPrefix($field)
    {
        if (isset($field['id'])) {
            $field['id'] = self::PREFIX . $field['id'];
        }

        return $field;
    }
}
