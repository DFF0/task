<?php

/**
 *
 * @var LocalMenu $LocalMenu
 */
class Layout
{
    protected $_scriptDirectory = null;

    protected $_scriptName = null;

    protected $_enabled = null;

    protected $_content = null;

    protected $_plugins = null;

    /**
     *
     * @var Response
     */
    protected $_response = null;

    /**
     *
     * @return Plugins
     */
    public function plugins()
    {
        if (!isset($this->_plugins))
            $this->_plugins = new Plugins();

        return $this->_plugins;
    }

    public function setResponse(Response $response)
    {
        $this->_response = $response;
    }

    public function enable()
    {
        $this->_enabled = true;
    }

    public function disable()
    {
        $this->_enabled = false;
    }

    public function enabled()
    {
        return $this->_enabled;
    }

    public function setContent($content)
    {
        $this->_content = $content;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function setScriptName($scriptName)
    {
        $this->_scriptName = $scriptName;
    }

    public function getScriptName()
    {
        return $this->_scriptName ?: 'Layout.phtml';
    }

    public function setScriptDirectory($directory)
    {
        $this->_scriptDirectory = $directory;
    }

    public function getScriptDirectory()
    {
        return $this->_scriptDirectory ?: 'Scripts/Layouts';
    }

    public function getScript()
    {
        return $this->getScriptDirectory() . '/' . $this->getScriptName();
    }

    public function render()
    {
        $script = $this->getScript();

        if (!file_exists($script) || !is_readable($script))
            throw new Exception('Invalid layout script ' . $script);

        include $script;
    }

    public function __get($pluginName)
    {
        return $this->plugins()->__get($pluginName);
    }
}