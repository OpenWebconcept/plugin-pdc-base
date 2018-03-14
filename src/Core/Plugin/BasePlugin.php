<?php

namespace OWC_PDC_Base\Core\Plugin;

use OWC_PDC_Base\Core\Config;
use OWC_PDC_Base\Core\Admin\Admin;

abstract class BasePlugin
{

    /**
     * Path to the root of the plugin.
     *
     * @var string
     */
    protected $rootPath;

    /**
     * Instance of the configuration repository.
     *
     * @var \OWC_PDC_Base\Core\Config
     */
    public $config;

    /**
     * Instance of the hook loader.
     */
    public $loader;

    /**
     * Creates the base plugin functionality.
     *
     * Create startup hooks and tear down hooks.
     * Boot up admin and frontend functionality.
     * Register the actions and filters from the loader.
     *
     * @param string $rootPath
     */
    public function __construct($rootPath)
    {
        $this->rootPath = $rootPath;

	    $this->loader = Loader::getInstance();

        $this->config = new Config($this->rootPath.'/config');
        $this->config->boot();

        $this->bootServiceProviders();

        $this->addStartUpHooks();
        $this->addTearDownHooks();

//        if (is_admin()) {
//            $admin = new Admin($this);
//            $admin->boot();
//        }

        $this->loader->register();
    }

    /**
     * Boot service providers
     */
    private function bootServiceProviders()
    {
        $services = $this->config->get('core.providers');

        foreach ($services as $service) {
            // Only boot global service providers here.
            if (is_array($service)) {
                continue;
            }

            $service = new $service($this);

            if ( ! $service instanceof ServiceProvider) {
                throw new \Exception('Provider must extend ServiceProvider.');
            }

            /**
             * @var \OWC_PDC_Base\Core\Plugin\ServiceProvider $service
             */
            $service->register();
        }
    }

    /**
     * Startup hooks to initialize the plugin.
     */
    private function addStartUpHooks()
    {
        /**
         * This hook registers a plugin function to be run when the plugin is activated.
         */
        register_activation_hook(__FILE__, [ 'OWC_PDC_Base\Core\Hooks', 'pluginActivation' ]);

        /**
         * This hook is run immediately after any plugin is activated, and may be used to detect the activation of plugins.
         * If a plugin is silently activated (such as during an update), this hook does not fire.
         */
        add_action('activated_plugin', [ 'OWC_PDC_Base\Core\Hooks', 'pluginActivated' ], 10, 2);
    }

    /**
     * Teardown hooks to cleanup or uninstall the plugin.
     */
    private function addTearDownHooks()
    {
        /**
         * This hook is run immediately after any plugin is deactivated, and may be used to detect the deactivation of other plugins.
         */
        add_action('deactivated_plugin', [ 'OWC_PDC_Base\Core\Hooks', 'pluginDeactivated' ], 10, 2);

        /**
         * This hook registers a plugin function to be run when the plugin is deactivated.
         */
        register_deactivation_hook(__FILE__, [ 'OWC_PDC_Base\Core\Hooks', 'pluginDeactivation' ]);

        /**
         * Registers the uninstall hook that will be called when the user clicks on the uninstall link that calls for the plugin to uninstall itself.
         * The link won’t be active unless the plugin hooks into the action.
         */
        register_uninstall_hook(__FILE__, [ 'OWC_PDC_Base\Core\Hooks', 'uninstallPlugin' ]);
    }

    /**
     * Get the name of the plugin.
     *
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * Get the version of the plugin.
     *
     * @return string
     */
    public function getVersion()
    {
        return static::VERSION;
    }

}