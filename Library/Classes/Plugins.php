<?php

class Plugins
{
    protected $_plugins = null;

    public function __construct()
    {
        $this->_plugins = [];
    }

    public function register($pluginName)
    {
        if (isset($this->_plugins[$pluginName]))
            return true;

        if (!class_exists($pluginName))
            throw new Exception('Plugins class ' . $pluginName . ' does not exist');

        $this->_plugins[$pluginName] = new $pluginName;

        return true;
    }

    /**
     *
     * @param string $pluginName
     * @return Plugin
     */
    public function __get($pluginName)
    {
        if (!isset($this->_plugins[$pluginName]))
            $this->register($pluginName);

        return $this->_plugins[$pluginName];
    }
}