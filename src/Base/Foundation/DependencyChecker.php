<?php

namespace OWC\PDC\Base\Foundation;

class DependencyChecker
{

    /**
     * Plugins that need to be checked for.
     *
     * @var array
     */
    private $dependencies;

    /**
     * Build up array of failed plugins, either because
     * they have the wrong version or are inactive.
     *
     * @var array
     */
    private $failed = [];

    /**
     * Determine which plugins need to be present.
     *
     * @param array $dependencies
     */
    public function __construct(array $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    /**
     * Determines if the dependencies are not met.
     *
     * @return bool
     */
    public function failed(): bool
    {
        foreach ($this->dependencies as $dependency) {
            switch ($dependency['type']) {
                case 'class':
                    $this->checkClass($dependency);
                    break;
                case 'plugin':
                    $this->checkPlugin($dependency);
                    break;
            }
        }

        return count($this->failed) > 0;
    }

    /**
     * Notifies the administrator which plugins need to be enabled,
     * or which plugins have the wrong version.
     */
    public function notify()
    {
        add_action('admin_notices', function () {
            $list = '<p>'.__('De volgende plugins zijn vereist om gebruik te maken van de PDC:',
                    'pdc-base').'</p><ol>';

            foreach ($this->failed as $dependency) {
                $info = isset($dependency['message']) ? ' ('.$dependency['message'].')' : '';
                $list .= sprintf('<li>%s%s</li>', $dependency['label'], $info);
            }

            $list .= '</ol>';

            printf('<div class="notice notice-error"><p>%s</p></div>', $list);
        });
    }

    /**
     * Marks a dependency as failed.
     *
     * @param array  $dependency
     * @param string $defaultMessage
     */
    private function markFailed(array $dependency, string $defaultMessage)
    {
        $this->failed[] = array_merge([
            'message' => $dependency['message'] ?? $defaultMessage
        ], $dependency);
    }

    /**
     *
     *
     * @param array $dependency
     */
    private function checkClass(array $dependency)
    {
        if ( ! class_exists($dependency['name'])) {
            $this->markFailed($dependency, __('Class does not exist', 'pdc-base'));

            return;
        }
    }

    /**
     * Check if a plugin is enabled and has the correct version.
     *
     * @param array $dependency
     */
    private function checkPlugin(array $dependency)
    {
        if ( ! is_plugin_active($dependency['file'])) {
            $this->markFailed($dependency, __('Inactive', 'pdc-base'));

            return;
        }

        // If there is a version lock set on the dependency...
        if (isset($dependency['version'])) {
            if ( ! $this->checkVersion($dependency)) {
                $this->markFailed($dependency, __('Minimal version:', 'pdc-base').' <b>'.$dependency['version'].'</b>');
            }
        }
    }

    /**
     * Checks the installed version of the plugin.
     *
     * @param array $dependency
     *
     * @return bool
     */
    private function checkVersion(array $dependency): bool
    {
        $file = file_get_contents(WP_PLUGIN_DIR.'/'.$dependency['file']);

        preg_match('/^(?: ?\* ?Version: ?)(.*)$/m', $file, $matches);
        $version = isset($matches[1]) ? str_replace(' ', '', $matches[1]) : '0.0.0';

        return version_compare($version, $dependency['version'], '>=');
    }

}