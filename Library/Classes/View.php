<?php

class View extends ViewAbstract
{
    protected $_scriptDirectory = null;

    protected $_scriptName = null;

    protected $_enabled = null;

    /**
     *
     * @var Layout
     */
    protected $_layout = null;

    /**
     *
     * @var Response
     */
    protected $_response = null;

    /**
     *
     * @var Request
     */
    protected $_request = null;

    public function setLayout(Layout $layout)
    {
        $this->_layout = $layout;
    }

    public function setResponse(Response $response)
    {
        $this->_response = $response;
    }

    public function setRequest(Request $request)
    {
        $this->_request = $request;
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

    public function setScriptName($scriptName)
    {
        $this->_scriptName = $scriptName;
    }

    public function getScriptName()
    {
        return $this->_scriptName ?: 'Index.phtml';
    }

    public function setScriptDirectory($directory)
    {
        $this->_scriptDirectory = $directory;
    }

    public function getScriptDirectory()
    {
        return $this->_scriptDirectory ?: 'Scripts/Views';
    }

    public function getScript()
    {
        return $this->getScriptDirectory() . '/' . $this->getScriptName();
    }

    public function render()
    {
        $script = $this->getScript();

        if (!is_readable($script))
            throw new Exception('The view script ' . $script . ' is not readable');

        include $script;
    }
}