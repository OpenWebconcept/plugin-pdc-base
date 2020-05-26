<?php

/**
 * PHPUnit bootstrap file
 */

/**
 * Load dependencies with Composer autoloader.
 */
require __DIR__ . '/../../vendor/autoload.php';

define('WP_PLUGIN_DIR', __DIR__);

/**
 * Bootstrap WordPress Mock.
 */
\WP_Mock::setUsePatchwork(true);
\WP_Mock::bootstrap();

$GLOBALS['pdc-base'] = [
    'active_plugins' => ['pdc-base/pdc-base.php'],
];
