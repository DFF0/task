<?php

class Request
{
    protected $_params = null;

    protected $_controllerName = null;

    protected $_actionName = null;

    public function __construct($params = null)
    {
        $this->_params = [];

        if (is_array($params))
            $this->setParams($params);
    }

    public function getParam($key, $default = null)
    {
        if (isset($this->_params[$key]))
            return $this->_params[$key];

        return $default;
    }

    public function setParams($params)
    {
        foreach ($params as $key => $value)
            $this->setParam($key, $value);
    }

    public function setParam($key, $value)
    {
        $this->_params[$key] = $value;
    }

    public function setControllerName($controllerName)
    {
        $this->_controllerName = $controllerName;
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }

    public function setActionName($actionName)
    {
        $this->_actionName = $actionName;
    }

    public function getActionName()
    {
        return $this->_actionName;
    }
}