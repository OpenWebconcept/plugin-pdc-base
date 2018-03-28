<?php

namespace OWC_PDC_Base\Core;

class Hooks
{

    /**
     * This method is called when the plugin is being activated.
     */
    public static function pluginActivation()
    {

    }

    /**
     * This method is called immediately after any plugin is activated, and may be used to detect the activation of
     * plugins. If a plugin is silently activated (such as during an update), this hook does not fire.
     */
    public static function pluginActivated($plugin, $networkActivation)
    {

    }

    /**
     * This method is run immediately after any plugin is deactivated, and may be used to detect the deactivation of
     * other plugins.
     */
    public static function pluginDeactivated($plugin, $networkActivation)
    {

    }

    /**
     * This method registers a plugin function to be run when the plugin is deactivated.
     */
    public static function pluginDeactivation()
    {

    }

    /**
     * This method is run when the plugin is activated.
     * This method run is when the user clicks on the uninstall link that calls for the plugin to uninstall itself.
     * The link won’t be active unless the plugin hooks into the action.
     */
    public static function uninstallPlugin()
    {

    }

    /**
     * Helper to activate a plugin on another site without causing a fatal error by
     * including the plugin file a second time. Based on activate_plugin() in
     * wp-admin/includes/plugin.php
     *
     * $buffer option is used for All in One SEO Pack, which sends output otherwise
     *
     * @param          $plugin
     * @param  boolean $buffer
     */
    private function activateCurrentPlugin($plugin, $buffer = false)
    {
        $current = get_option('active_plugins', []);
        if ( ! in_array($plugin, $current)) {
            if ($buffer) {
                ob_start();
            }
            include_once(WP_PLUGIN_DIR.'/'.$plugin);
            do_action('activate_plugin', $plugin);
            do_action('activate_'.$plugin);
            $current[] = $plugin;
            sort($current);
            update_option('active_plugins', $current);
            do_action('activated_plugin', $plugin);
            if ($buffer) {
                ob_end_clean();
            }
        }
    }

    public function activateAppOnNewBlog($blogId, $userId, $domain, $path, $siteId, $meta)
    {

    }
}