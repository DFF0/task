<?php

abstract class Plugin
{
    public function getViewScriptDirectory()
    {
        return 'Scripts/Layouts/Plugins';
    }

    public function getViewScriptName()
    {
        $className = get_class($this);

        return $className . '.phtml';
    }

    public function getViewScript()
    {
        return $this->getViewScriptDirectory() . '/' . $this->getViewScriptName();
    }

    public function render()
    {
        $script = $this->getViewScript();

        if (!is_readable($script))
            return ('Plugin view script ' . $script . ' is not readable');

        ob_start();
        include $script;

        return ob_get_clean();
    }

    public function __toString()
    {
        return $this->render();
    }
}