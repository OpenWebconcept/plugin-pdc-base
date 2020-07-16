<?php

namespace OWC\PDC\Base;

class Autoloader
{
    /**
     * Autoloader constructor.
     * PSR autoloader
     */
    public function __construct()
    {
        spl_autoload_register([$this, 'autoloader']);
    }

    /**
     * Autoload all the PDC Base files
     *
     * @param string $className
     *
     * @return void
     */
    private function autoloader(string $className):void
    {
        $baseDir   = __DIR__ . '/src/Base/';
        $namespace = str_replace("\\", "/", __NAMESPACE__);
        $className = str_replace("\\", "/", $className);
        $class     = $baseDir . (empty($namespace) ? "" : $namespace . "/") . $className . '.php';
        $class     = str_replace('/OWC/PDC/Base/OWC/PDC/Base/', '/', $class);
        if (file_exists($class)) {
            require_once($class);
        }
    }
}
