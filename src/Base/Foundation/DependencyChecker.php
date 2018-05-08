<?php

namespace OWC\PDC\Base\Foundation;

class DependencyChecker
{

    /**
     * Instance of the Plugin.
     *
     * @var Plugin
     */
    private $plugin;

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
     * @param Plugin $plugin
     * @param array  $dependencies
     */
    public function __construct(Plugin $plugin, array $dependencies)
    {
        $this->plugin = $plugin;
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
            $this->checkPlugin($dependency);
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
                    $this->plugin->getName()).'</p><ol>';

            foreach ($this->failed as $dependency) {
                $info = isset($dependency['message']) ? ' ('.$dependency['message'].')' : '';
                $list .= sprintf('<li>%s%s</li>', $dependency['label'], $info);
            }

            $list .= '</ol>';

            printf('<div class="notice notice-error"><p>%s</p></div>', $list);
        });
    }

    /**
     * Check if a plugin is enabled and has the correct version.
     *
     * @param array $dependency
     */
    private function checkPlugin(array $dependency)
    {
        if ( ! is_plugin_active($dependency['file'])) {
            $this->failed[] = array_merge([
                'message' => __('Inactief', $this->plugin->getName())
            ], $dependency);

            return;
        }

        // If there is a version lock set on the dependency...
        if (isset($dependency['version'])) {
            if ( ! $this->checkVersion($dependency)) {
                $this->failed[] = array_merge([
                    'message' => __('Minimale versie:', $this->plugin->getName()).' <b>'.$dependency['version'].'</b>'
                ], $dependency);
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

        return version_compare($matches[1] ?? 0, $dependency['version'], '>=');
    }

}