<?php

class Autoloader
{
    protected $_directories = [];

    protected $_registered = null;

    public function register()
    {
        if (!$this->_registered)
            spl_autoload_register([$this, 'load']);
    }

    public function unregister()
    {
        if ($this->_registered)
            spl_autoload_unregister([$this, 'load']);
    }

    public function load($class)
    {
        $fileName = strtr($class, '\\', '/') . '.php';

        foreach ($this->_directories as $directory) {
            $filePath = $directory . '/' . $fileName;

            if (file_exists($filePath)) {
                include $filePath;
                break;
            }
        }
    }

    public function addDirectory($directory)
    {
        $this->_directories[] = $directory;
    }

    public function addDirectories(array $directories)
    {
        foreach ($directories as $directory)
            $this->addDirectory($directory);
    }
}