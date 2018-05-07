<?php

namespace OWC\PDC\Base\Foundation;

use OWC\PDC\Base\Admin\Admin;

class Plugin
{

    /**
     * Name of the plugin.
     *
     * @var string
     */
    const NAME = 'pdc-base';

    /**
     * Version of the plugin.
     * Used for setting versions of enqueue scripts and styles.
     *
     * @var string
     */
    const VERSION = '1.1';

    /**
     * Path to the root of the plugin.
     *
     * @var string
     */
    protected $rootPath;

    /**
     * Instance of the configuration repository.
     *
     * @var \OWC\PDC\Base\Config
     */
    public $config;

    /**
     * Instance of the Hook loader.
     *
     * @var Loader
     */
    public $loader;

    /**
     * @see \OWC\PDC\Base\Settings\SettingsServiceProvider
     *
     * @var array
     */
    public $settings;

    public function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
        $this->loadPluginTextdomain();

        $this->loader = Loader::getInstance();

        $this->config = new Config($this->rootPath.'/config');

        $this->addStartUpHooks();
        $this->addTearDownHooks();
    }

    /**
     * Boot the plugin.
     * Called on plugins_loaded event
     */
    public function boot()
    {
        $this->config->setProtectedNodes([ 'core' ]);
        $this->config->boot();

        $this->bootServiceProviders();

        if (is_admin()) {
            $admin = new Admin($this);
            $admin->boot();
        }

        $this->loader->addAction('init', $this, 'filterPlugin', 4);

        $this->loader->register();
    }

    public function filterPlugin()
    {
        do_action('owc/'.self::NAME.'/plugin', $this);
    }

    /**
     * Boot service providers
     */
    public function bootServiceProviders()
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
             * @var \OWC\PDC\Base\Foundation\ServiceProvider $service
             */
            $service->register();
        }
    }

    public function loadPluginTextdomain()
    {
        load_plugin_textdomain($this->getName(), false, $this->getName().'/languages/');
    }

    /**
     * Get the name of the plugin.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * Get the version of the plugin.
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Startup hooks to initialize the plugin.
     */
    private function addStartUpHooks()
    {
        /**
         * This hook registers a plugin function to be run when the plugin is activated.
         */
        register_activation_hook(__FILE__, [ 'OWC\PDC\Base\Hooks', 'pluginActivation' ]);

        /**
         * This hook is run immediately after any plugin is activated, and may be used to detect the activation of plugins.
         * If a plugin is silently activated (such as during an update), this hook does not fire.
         */
        add_action('activated_plugin', [ 'OWC\PDC\Base\Hooks', 'pluginActivated' ], 10, 2);
    }

    /**
     * Teardown hooks to cleanup or uninstall the plugin.
     */
    private function addTearDownHooks()
    {
        /**
         * This hook is run immediately after any plugin is deactivated, and may be used to detect the deactivation of other plugins.
         */
        add_action('deactivated_plugin', [ 'OWC\PDC\Base\Hooks', 'pluginDeactivated' ], 10, 2);

        /**
         * This hook registers a plugin function to be run when the plugin is deactivated.
         */
        register_deactivation_hook(__FILE__, [ 'OWC\PDC\Base\Hooks', 'pluginDeactivation' ]);

        /**
         * Registers the uninstall hook that will be called when the user clicks on the uninstall link that calls for the plugin to uninstall itself.
         * The link won’t be active unless the plugin hooks into the action.
         */
        register_uninstall_hook(__FILE__, [ 'OWC\PDC\Base\Hooks', 'uninstallPlugin' ]);
    }

}