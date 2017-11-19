<?php

class LocalMenu extends Plugin
{
    protected $_menuList = [];

    public function add($html)
    {
        $this->_menuList[] = $html;
    }
}