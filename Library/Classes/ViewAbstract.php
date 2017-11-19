<?php

class ViewAbstract
{
    protected $_variables = null;

    public function __construct()
    {
        $this->resetVariables();
    }

    public function resetVariables()
    {
        $this->_variables = [];
    }

    public function __get($key)
    {
        if (isset($this->_variables[$key]))
            return $this->_variables[$key];

        return null;
    }

    public function __set($key, $value)
    {
        $this->_variables[$key] = $value;
    }
}