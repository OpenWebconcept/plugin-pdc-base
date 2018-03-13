<?php

namespace OWC_PDC_Base\Core;

class Config
{

    /**
     * Directory where config files are located.
     *
     * @var string
     */
    protected $path;

    /**
     * Array with all the config values.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Config repository constructor.
     *
     * Boot the configuration files and get all the files from the
     * config directory and add them to the config array.
     *
     * @param string $path Path to the configuration files.
     * @param array  $items
     */
    public function __construct($path, array $items = [])
    {
        $this->items = $items;
        $this->path = $path;
    }

    /**
     * Boot up the configuration repository.
     */
    public function boot()
    {
        $this->scanDirectory($this->getPath());
    }

    /**
     * Retrieve a specific config value from the configuration repository.
     *
     * @param $setting
     *
     * @return array|mixed
     */
    public function get($setting)
    {
        if ( ! $setting) {
            return $this->all();
        }

        $parts = explode('.', $setting);

        $current = $this->items;

        foreach ($parts as $part) {
            $current = $current[$part];
        }

        return $current;
    }

    /**
     * Return all config values.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get the path where the files will be fetched from.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the path where the config files are fetched from.
     *
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    private function scanDirectory($path)
    {
        $files = glob($path.'/*');

        foreach ($files as $file) {
            $fileType = filetype($file);

            if ($fileType == "dir") {
                $this->scanDirectory($file);
            } else {
                $name = str_replace('.php', '', basename($file));
                $value = include $file;

                // If its in the first directory just add the file.
                if ($path == $this->path) {
                    $this->items[$name] = $value;
                    continue;
                }

                // Get the path from the starting path.
                $path = str_replace($this->path.'/', '', $path);

                // Build an array from the path.
                $items = [];
                $items[$name] = $value;
                foreach (array_reverse(explode('/', $path)) as $key) {
                    $items = [ $key => $items ];
                }

                // Merge it recursively into items
                $this->items = array_merge_recursive($this->items, $items);
            }
        }
    }

}